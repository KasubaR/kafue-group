<?php

namespace Tests\Feature;

use App\Http\Controllers\QuoteController;
use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_each_main_page_loads(): void
    {
        foreach (['/', '/products', '/services', '/about', '/contact'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_navigation_has_the_four_pages_and_marks_the_current_one(): void
    {
        $this->assertCount(4, config('site.nav'));

        $html = $this->get('/products')->getContent();
        foreach (config('site.nav') as $item) {
            $this->assertStringContainsString(route($item['route']), $html);
        }
        $this->assertMatchesRegularExpression('/<a href="[^"]*\/products"[^>]*aria-current="page"/', $html);
    }

    public function test_inner_pages_have_a_breadcrumb_back_to_home_and_home_does_not(): void
    {
        foreach (['/products' => 'Products', '/services' => 'Services', '/about' => 'About', '/contact' => 'Contact'] as $uri => $label) {
            $html = $this->get($uri)->assertOk()->getContent();

            $this->assertMatchesRegularExpression('/<nav class="breadcrumbs"[^>]*aria-label="Breadcrumb"/', $html, $uri);
            $this->assertMatchesRegularExpression('/<a href="[^"]*">Home<\/a>/', $html, $uri);
            $this->assertMatchesRegularExpression('/aria-current="page">\s*'.$label.'\s*</', $html, $uri);
            $this->assertStringContainsString('"@type":"BreadcrumbList"', $html, $uri);
        }

        $this->get('/')->assertDontSee('class="breadcrumbs"', false);
    }

    public function test_tab_icon_files_exist_and_are_linked_on_every_page(): void
    {
        foreach (['favicon.svg', 'favicon.ico', 'favicon-32.png'] as $file) {
            $this->assertFileExists(public_path($file));
        }

        foreach (['/', '/products', '/contact'] as $uri) {
            $this->get($uri)
                ->assertSee('favicon.svg', false)
                ->assertSee('favicon.ico', false);
        }
    }

    public function test_company_details_come_from_config(): void
    {
        $this->get('/contact')
            ->assertSee(config('site.phone'))
            ->assertSee('15 South Ridge', false);
    }

    public function test_contact_preselects_category_from_query(): void
    {
        $this->get('/contact?category='.urlencode('Safety and PPE'))
            ->assertSee('<option value="Safety and PPE" selected>', false);
    }

    public function test_products_page_shows_divisions_steel_and_tools(): void
    {
        $response = $this->get('/products')->assertOk();

        foreach (config('content.divisions') as $division) {
            $response->assertSee($division['title']);
        }
        $response->assertSee('id="steel"', false)
            ->assertSee('id="tools"', false)
            ->assertSee('I and H beams (IPE, UB, UC)', false)
            ->assertSee('Trade kits');
    }

    public function test_services_page_shows_services_rental_process_and_sectors(): void
    {
        $response = $this->get('/services')->assertOk();

        foreach (['services', 'rental', 'sectors'] as $key) {
            foreach (config("content.$key") as $item) {
                $response->assertSee($item['title']);
            }
        }
        foreach (config('content.steps') as $step) {
            $response->assertSee($step['title']);
        }
        $response->assertSee('id="rental"', false)
            ->assertSee('tel:+27602046268', false)
            ->assertSee('Call '.config('site.phone'));
    }

    public function test_about_page_shows_story_values_and_registration_details(): void
    {
        $response = $this->get('/about')->assertOk();

        foreach (config('content.values') as $value) {
            $response->assertSee($value['title']);
        }
        foreach (config('content.vendor_pack') as $doc) {
            $response->assertSee($doc);
        }
        $response->assertSee('Vision')
            ->assertSee('Mission')
            ->assertSee(config('site.registration'))
            ->assertDontSee('9041629339')
            ->assertDontSee('9470014541')
            ->assertSee('id="compliance"', false);
    }

    public function test_every_division_quote_category_exists_in_the_form(): void
    {
        foreach (config('content.division_links') as $title => $link) {
            if (isset($link['category'])) {
                $this->assertContains($link['category'], QuoteController::CATEGORIES, "$title category");
            }
        }
        foreach (config('content.supply') as $item) {
            $this->assertContains($item['category'], QuoteController::CATEGORIES, $item['title']);
        }
    }
}
