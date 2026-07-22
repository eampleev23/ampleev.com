<?php

namespace Tests\Feature;

use Tests\TestCase;

class YaiPageTest extends TestCase
{
    public function test_ru_page_renders_final_layout_with_brand_and_locale(): void
    {
        $response = $this->get('/aiya');

        $response->assertStatus(200);
        $response->assertSee('AIЯ');
        $response->assertSee('lang="ru"', false);
        $response->assertSee('aiya-page');
        $response->assertSee('aria-current="page"', false);
        $response->assertDontSee('ЯAI');
    }

    public function test_en_page_renders_final_layout_with_brand_and_locale(): void
    {
        $response = $this->get('/en/aiya');

        $response->assertStatus(200);
        $response->assertSee('AIЯ');
        $response->assertSee('lang="en"', false);
        $response->assertSee('aiya-page');
        $response->assertDontSee('ЯAI');
    }

    public function test_final_page_has_no_preview_leftovers(): void
    {
        $response = $this->get('/aiya');

        $response->assertDontSee('noindex');
        $response->assertDontSee('прототип v2');
        $response->assertDontSee('prototype v2');
        $response->assertDontSee('aiya-page--v');
    }

    public function test_final_page_markup_is_accessible(): void
    {
        $response = $this->get('/aiya');

        $response->assertSee('role="log"', false);
        $response->assertSee('aria-live="polite"', false);
        $response->assertSee('name="message"', false);
        $response->assertSee('maxlength="1200"', false);
        $response->assertSee('for="aiya-input"', false);
    }

    public function test_preview_urls_are_gone(): void
    {
        $this->get('/yai/v1')->assertStatus(404);
        $this->get('/yai/v2')->assertStatus(404);
        $this->get('/en/yai/v1')->assertStatus(404);
        $this->get('/en/yai/v2')->assertStatus(404);
    }

    public function test_old_urls_redirect_permanently_to_aiya(): void
    {
        $this->get('/yai')->assertStatus(301)->assertRedirect('/aiya');
        $this->get('/en/yai')->assertStatus(301)->assertRedirect('/en/aiya');
    }

    public function test_disabled_feature_returns_404_page_and_503_api(): void
    {
        config(['yai.enabled' => false]);

        $this->get('/aiya')->assertStatus(404);
        $this->postJson('/api/aiya/chat', ['message' => 'test'])->assertStatus(503);
    }
}
