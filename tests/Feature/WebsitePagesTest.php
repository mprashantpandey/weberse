<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsitePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_public_pages_are_available(): void
    {
        $this->get('/')->assertOk();
        $this->get('/about')->assertOk();
        $this->get('/services')->assertOk();
        $this->get('/services/mobile-app-development')->assertOk();
        $this->get('/portfolio')->assertOk();
        $this->get('/portfolio/zenflow-ops')->assertOk();
        $this->get('/case-studies')->assertOk();
        $this->get('/case-studies/scaling-a-modern-hosting-brand')->assertOk();
        $this->get('/blog')->assertOk();
        $this->get('/careers')->assertOk();
        $this->get('/hosting')->assertOk();
        $this->get('/contact')->assertOk();
    }

    public function test_seo_endpoints_are_available(): void
    {
        $robots = $this->get('/robots.txt');
        $robots
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap:', false);
        $this->assertStringContainsString('public', (string) $robots->headers->get('Cache-Control'));
        $this->assertStringContainsString('max-age=300', (string) $robots->headers->get('Cache-Control'));

        $sitemap = $this->get('/sitemap.xml');
        $sitemap
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false)
            ->assertSee('<urlset', false);
        $this->assertStringContainsString('public', (string) $sitemap->headers->get('Cache-Control'));
        $this->assertStringContainsString('max-age=300', (string) $sitemap->headers->get('Cache-Control'));
    }

    public function test_legacy_marketing_urls_redirect_to_current_pages(): void
    {
        $this->get('/why-us')
            ->assertRedirect('/about');

        $this->get('/digital-marketing')
            ->assertRedirect('/services/digital-marketing');

        $this->get('/ecommerce-development')
            ->assertRedirect('/services/web-development');
    }

    public function test_public_marketing_pages_send_public_cache_headers(): void
    {
        $home = $this->get('/');
        $home->assertOk();
        $this->assertStringContainsString('public', (string) $home->headers->get('Cache-Control'));
        $this->assertStringContainsString('max-age=300', (string) $home->headers->get('Cache-Control'));

        $about = $this->get('/about');
        $about->assertOk();
        $this->assertStringContainsString('public', (string) $about->headers->get('Cache-Control'));
        $this->assertStringContainsString('max-age=300', (string) $about->headers->get('Cache-Control'));
    }
}
