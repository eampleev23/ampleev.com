<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutMePageTest extends TestCase
{
    public function test_russian_about_page_has_the_approved_structure_and_positioning(): void
    {
        $response = $this->get('/about_me');

        $response->assertOk();
        $response->assertSee('lang="ru"', false);
        $response->assertSee('>Обо мне</a>', false);
        $response->assertSee('aria-current="page"', false);
        $response->assertSee('Выстраиваю поставку IT-продуктов — от приоритетов до production');
        $response->assertSee('Открыть резюме');
        $response->assertSee('Написать в Telegram');
        $response->assertSee('До 35');
        $response->assertSee('30% → 85%');
        $response->assertSee('продукт подготовлен к пилотированию');
        $response->assertDontSee('пилот не состоялся после выхода партнёра');
        $response->assertSeeInOrder([
            'about-profile__hero',
            'about-profile__proof',
            'about-profile__ownership',
            'about-profile__experience',
            'about-profile__products',
            'about-profile__ai',
            'about-profile__cta',
        ], false);

        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    public function test_english_about_page_matches_the_russian_page_structure(): void
    {
        $response = $this->get('/en/about_me');

        $response->assertOk();
        $response->assertSee('lang="en"', false);
        $response->assertSee('>About Me</a>', false);
        $response->assertSee('I build reliable software delivery—from priorities to production');
        $response->assertSee('View résumé (RU)');
        $response->assertSee('What I take ownership of');
        $response->assertSee('Products I have built');
        $response->assertSee('was prepared for a pilot');
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    public function test_about_page_has_seo_accessibility_and_counter_contracts(): void
    {
        $response = $this->get('/about_me');

        $response->assertOk();
        $response->assertSee('<title>Евгений Амплеев — IT Delivery Manager и руководитель поставки IT-продуктов</title>', false);
        $response->assertSee('<link rel="canonical" href="' . route('static_pages.about_me') . '">', false);
        $response->assertSee('"@type":"Person"', false);
        $response->assertDontSee('"sameAs"', false);
        $response->assertSee('aria-live="off"', false);
        $response->assertSee('data-ai-usage-poll-interval="60000"', false);
        $response->assertSee('width="1280"', false);
        $response->assertSee('height="1254"', false);
    }

    public function test_resume_routes_serve_the_same_stable_pdf_with_cache_validators(): void
    {
        $inline = $this->get('/resume');

        $inline->assertOk();
        $inline->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('inline', (string) $inline->headers->get('content-disposition'));
        $this->assertNotEmpty($inline->headers->get('etag'));
        $this->assertNotEmpty($inline->headers->get('last-modified'));
        $this->assertStringNotContainsString('immutable', (string) $inline->headers->get('cache-control'));

        $head = $this->call('HEAD', '/resume');
        $head->assertOk();
        $head->assertHeader('content-type', 'application/pdf');
        $this->assertFalse($head->getContent());

        $download = $this->get('/resume/download');
        $download->assertOk();
        $download->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('attachment', (string) $download->headers->get('content-disposition'));
        $this->assertStringContainsString('evgeniy-ampleev-resume-ru.pdf', (string) $download->headers->get('content-disposition'));
        $this->assertSame($inline->getContent(), $download->getContent());
    }
}
