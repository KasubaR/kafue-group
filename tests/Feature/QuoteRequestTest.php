<?php

namespace Tests\Feature;

use App\Mail\QuoteRequestReceived;
use App\Models\QuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test Buyer',
            'company' => 'Acme Mining',
            'email' => 'buyer@example.com',
            'category' => 'Pumps and spares',
            'details' => '2 x slurry pumps and spare impellers',
        ], $overrides);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Mail::fake();
        config(['site.mail.sales' => null, 'site.mail.tools' => null]);
    }

    public function test_request_is_validated(): void
    {
        $this->post('/quote', [])
            ->assertSessionHasErrors(['name', 'email', 'category', 'details']);

        $this->assertDatabaseCount('quote_requests', 0);
    }

    public function test_valid_request_is_saved_and_confirmed(): void
    {
        $this->post('/quote', $this->payload())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('quote_requests', ['email' => 'buyer@example.com', 'category' => 'Pumps and spares']);
    }

    public function test_request_is_saved_but_no_email_sent_when_no_address_is_configured(): void
    {
        $this->post('/quote', $this->payload())->assertSessionHas('status');

        Mail::assertNothingSent();
        $this->assertNull(QuoteRequest::first()->emailed_at);
    }

    public function test_general_and_steel_requests_go_to_sales(): void
    {
        config(['site.mail.sales' => 'sales@example.com', 'site.mail.tools' => 'tools@example.com']);

        $this->post('/quote', $this->payload(['category' => 'Steel and plate']));
        $this->post('/quote', $this->payload(['category' => 'Safety and PPE']));

        Mail::assertSent(QuoteRequestReceived::class, 2);
        Mail::assertSent(QuoteRequestReceived::class, fn ($m) => $m->hasTo('sales@example.com'));
        Mail::assertNotSent(QuoteRequestReceived::class, fn ($m) => $m->hasTo('tools@example.com'));
        $this->assertNotNull(QuoteRequest::first()->emailed_at);
    }

    public function test_tools_requests_go_to_the_tools_address_when_set(): void
    {
        config(['site.mail.sales' => 'sales@example.com', 'site.mail.tools' => 'tools@example.com']);

        $this->post('/quote', $this->payload(['category' => 'Tools and equipment', 'site_country' => 'Zambia, Kitwe']));

        Mail::assertSent(QuoteRequestReceived::class, fn ($m) => $m->hasTo('tools@example.com'));
        $this->assertDatabaseHas('quote_requests', ['site_country' => 'Zambia, Kitwe']);
    }

    public function test_tools_requests_fall_back_to_sales_without_a_tools_address(): void
    {
        config(['site.mail.sales' => 'sales@example.com', 'site.mail.tools' => null]);

        $this->post('/quote', $this->payload(['category' => 'Tools and equipment']));

        Mail::assertSent(QuoteRequestReceived::class, fn ($m) => $m->hasTo('sales@example.com'));
    }

    public function test_steel_request_keeps_required_by_date_and_rejects_past_dates(): void
    {
        $this->post('/quote', $this->payload(['category' => 'Steel and plate', 'required_by' => now()->addWeeks(3)->toDateString()]))
            ->assertSessionHasNoErrors();
        $this->assertNotNull(QuoteRequest::first()->required_by);

        $this->post('/quote', $this->payload(['required_by' => '2020-01-01']))
            ->assertSessionHasErrors('required_by');
    }

    public function test_attachment_is_stored_privately(): void
    {
        $file = UploadedFile::fake()->create('cutting-list.pdf', 200, 'application/pdf');

        $this->post('/quote', $this->payload(['attachment' => $file]))->assertSessionHasNoErrors();

        $quote = QuoteRequest::first();
        $this->assertSame('cutting-list.pdf', $quote->attachment_name);
        Storage::disk('local')->assertExists($quote->attachment_path);
    }

    public function test_unsafe_or_oversized_attachments_are_rejected(): void
    {
        $this->post('/quote', $this->payload(['attachment' => UploadedFile::fake()->create('run.exe', 10)]))
            ->assertSessionHasErrors('attachment');

        $this->post('/quote', $this->payload(['attachment' => UploadedFile::fake()->create('big.pdf', 20000, 'application/pdf')]))
            ->assertSessionHasErrors('attachment');

        $this->assertDatabaseCount('quote_requests', 0);
    }

    public function test_filled_honeypot_is_treated_as_spam_and_not_saved(): void
    {
        $this->post('/quote', $this->payload(['website' => 'http://spam.example']))
            ->assertRedirect(route('contact'));

        $this->assertDatabaseCount('quote_requests', 0);
        Mail::assertNothingSent();
    }

    public function test_submissions_are_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/quote', $this->payload());
        }

        $this->post('/quote', $this->payload())->assertStatus(429);
    }

    public function test_attachment_label_follows_the_selected_category(): void
    {
        $this->get('/contact?category='.urlencode('Tools and equipment'))->assertSee('Attach a tool list, drawings or spreadsheets');
        $this->get('/contact?category='.urlencode('Steel and plate'))->assertSee('Attach your cutting list, drawings or spreadsheets');
        $this->get('/contact')->assertSee('Attach drawings or spreadsheets');
    }

    public function test_form_renders_conditional_fields_and_the_honeypot(): void
    {
        $this->get('/contact')
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="required_by"', false)
            ->assertSee('name="site_country"', false)
            ->assertSee('name="attachment"', false)
            ->assertSee('data-dropzone', false)
            ->assertSee('data-max-kb="'.config('site.attachments.max_kb').'"', false)
            ->assertSee('name="website"', false);
    }
}
