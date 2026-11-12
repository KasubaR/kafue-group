<?php

namespace Tests\Feature;

use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminQuotesTest extends TestCase
{
    use RefreshDatabase;

    private function quote(array $overrides = []): QuoteRequest
    {
        return QuoteRequest::create($overrides + [
            'category' => 'Steel and plate',
            'name' => 'Thabo Mokoena',
            'company' => 'Kimberley Mining',
            'email' => 'thabo@example.com',
            'phone' => '060 000 0000',
            'project' => 'Pit 4 conveyor',
            'details' => '10 x 12m IPE 200',
        ]);
    }

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $quote = $this->quote();

        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get(route('admin.quotes.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.quotes.show', $quote))->assertRedirect(route('admin.login'));
        $this->post(route('admin.quotes.handled', $quote))->assertRedirect(route('admin.login'));
        $this->get(route('admin.quotes.attachment', $quote))->assertRedirect(route('admin.login'));
    }

    public function test_login_page_is_not_indexed(): void
    {
        $this->get(route('admin.login'))->assertOk()->assertSee('noindex', false);
    }

    public function test_admin_can_sign_in_and_out(): void
    {
        $user = User::factory()->create(['password' => 'correct-horse-battery']);

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'correct-horse-battery'])
            ->assertRedirect(route('admin.quotes.index'));
        $this->assertAuthenticatedAs($user);

        $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_signed_in_admin_skips_the_login_page(): void
    {
        $this->actingAs(User::factory()->create())->get(route('admin.login'))
            ->assertRedirect(route('admin.quotes.index'));
    }

    public function test_list_filters_by_status_and_search(): void
    {
        $this->quote(['name' => 'Fresh Request']);
        $this->quote(['name' => 'Old Request', 'handled_at' => now()]);
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.quotes.index'))
            ->assertOk()->assertSee('Fresh Request')->assertDontSee('Old Request');
        $this->get(route('admin.quotes.index', ['show' => 'handled']))
            ->assertSee('Old Request')->assertDontSee('Fresh Request');
        $this->get(route('admin.quotes.index', ['show' => 'all']))
            ->assertSee('Old Request')->assertSee('Fresh Request');
        $this->get(route('admin.quotes.index', ['show' => 'all', 'q' => 'Old']))
            ->assertSee('Old Request')->assertDontSee('Fresh Request');
    }

    public function test_detail_page_shows_the_request_and_escapes_html(): void
    {
        $quote = $this->quote(['details' => '<script>alert(1)</script>']);

        $this->actingAs(User::factory()->create())->get(route('admin.quotes.show', $quote))
            ->assertOk()
            ->assertSee('Thabo Mokoena')
            ->assertSee('Pit 4 conveyor')
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_request_can_be_marked_handled_and_reopened(): void
    {
        $quote = $this->quote();
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.quotes.handled', $quote))->assertRedirect();
        $this->assertNotNull($quote->fresh()->handled_at);

        $this->post(route('admin.quotes.handled', $quote))->assertRedirect();
        $this->assertNull($quote->fresh()->handled_at);
    }

    public function test_attachment_downloads_for_admins_only(): void
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('cutting-list.pdf', 20, 'application/pdf');
        $path = $file->store('quote-attachments');
        $quote = $this->quote(['attachment_path' => $path, 'attachment_name' => 'cutting-list.pdf']);

        $this->get(route('admin.quotes.attachment', $quote))->assertRedirect(route('admin.login'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.quotes.attachment', $quote))
            ->assertOk()
            ->assertDownload('cutting-list.pdf');
    }

    public function test_notification_email_links_to_the_admin_page(): void
    {
        $quote = $this->quote();

        (new \App\Mail\QuoteRequestReceived($quote))
            ->assertSeeInText(route('admin.quotes.show', $quote))
            ->assertSeeInText('Thabo Mokoena');
    }

    public function test_missing_attachment_is_a_404(): void
    {
        $quote = $this->quote();

        $this->actingAs(User::factory()->create())
            ->get(route('admin.quotes.attachment', $quote))->assertNotFound();
    }

    public function test_admin_command_creates_a_user_who_can_sign_in(): void
    {
        $this->artisan('admin:create', ['email' => 'Boss@Example.com', '--name' => 'The Boss'])
            ->expectsQuestion('Password (min 12 characters)', 'a-long-enough-pass')
            ->expectsQuestion('Repeat the password', 'a-long-enough-pass')
            ->assertSuccessful();

        $this->post(route('admin.login.store'), ['email' => 'boss@example.com', 'password' => 'a-long-enough-pass'])
            ->assertRedirect(route('admin.quotes.index'));
    }

    public function test_admin_command_rejects_short_passwords(): void
    {
        $this->artisan('admin:create', ['email' => 'boss@example.com'])
            ->expectsQuestion('Password (min 12 characters)', 'short')
            ->assertFailed();

        $this->assertDatabaseCount('users', 0);
    }
}
