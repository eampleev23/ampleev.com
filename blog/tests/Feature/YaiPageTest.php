<?php

namespace Tests\Feature;

use Tests\TestCase;

class YaiPageTest extends TestCase
{
    public function test_ru_page_renders_brand_and_consistent_locale(): void
    {
        $response = $this->get('/yai');

        $response->assertStatus(200);
        $response->assertSee('AIЯ');
        $response->assertSee('lang="ru"', false);
        $response->assertDontSee('ЯAI');
    }

    public function test_en_page_renders_brand_and_consistent_locale(): void
    {
        $response = $this->get('/en/yai');

        $response->assertStatus(200);
        $response->assertSee('AIЯ');
        $response->assertSee('lang="en"', false);
        $response->assertDontSee('ЯAI');
    }

    public function test_preview_variants_render_with_noindex_and_active_nav(): void
    {
        foreach (['v1', 'v2'] as $variant) {
            $response = $this->get('/yai/' . $variant);

            $response->assertStatus(200);
            $response->assertSee('AIЯ');
            $response->assertSee('noindex, nofollow');
            $response->assertSee('aiya-page--' . $variant);
            $response->assertSee('nav-link--aiya-' . $variant);
            $response->assertSee('aria-current="page"', false);
            $response->assertSee('role="log"', false);
        }
    }

    public function test_en_preview_variant_renders(): void
    {
        $response = $this->get('/en/yai/v2');

        $response->assertStatus(200);
        $response->assertSee('lang="en"', false);
        $response->assertSee('aiya-page--v2');
    }

    public function test_unknown_variant_returns_404(): void
    {
        $this->get('/yai/v3')->assertStatus(404);
    }

    public function test_disabled_feature_returns_404_page_and_503_api(): void
    {
        config(['yai.enabled' => false]);

        $this->get('/yai')->assertStatus(404);
        $this->get('/yai/v1')->assertStatus(404);
        $this->postJson('/api/yai/chat', ['message' => 'test'])->assertStatus(503);
    }
}
