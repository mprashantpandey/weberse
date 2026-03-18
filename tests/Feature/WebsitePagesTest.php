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
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap:', false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false)
            ->assertSee('<urlset', false);
    }
}
