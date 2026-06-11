<?php

/*
 * Base RU text_url lists per article series. Series-specific UI (card color
 * coding, badges, hero kickers) is driven by these explicit lists, never by
 * blog section: a section can contain articles from different series.
 */
$scrumAiSeriesSlugs = [
    'backlog_refinement_i_ai_chto_realno_menyaetsya',
    'ai_assisted_sprint_planning_kak_uskorit_podgotovku_ne_poteryav_otvetstvennost',
    'daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom',
    'sprint_review_i_ai_pochemu_demo_ne_zamenyaet_razgovor_o_tsennosti',
    'sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli',
    'ai_i_scrum_events_chto_realno_menyaetsya_vo_vstrechah_komandy_razrabotki',
];

$scrumSafeSeriesSlugs = [
    // У трёх старых статей прод и локальная БД используют разную транслитерацию —
    // включены оба варианта слага.
    'kak_vyschityvat_znacheniya_v_burn_down_chart_v_scrum',
    'kak_vischitivat_znachenia_v_burn_down_chart_v_scrum',
    'spetsifika_raboty_agile_komandy_v_safe_otnositelno_scrum_na_praktike',
    'specifika_raboti_komandi_v_safe_otnositelno_scrum',
    'praktika_primenenia_cumulative_flow_v_kontekste_scrum_i_safe',
    'praktika_ispolzovaniya_personalnogo_reytinga_kazhdogo_chlena_komandy_v_kontekste_scrum_i_safe',
    'praktika_ispolzovania_personalnogo_retinga_kazhdogo_chlena_komandi_v_kontekste_scrum_i_safe',
    'praktika_primenenia_burn_down_charts_v_kontekste_safe_i_scrum',
];

$aiAgentsSeriesSlugs = [
    'kak_chestno_sravnit_llm_na_svoyom_kode_eksperiment_s_tremya_modelyami_claude',
    'granitsy_vmesto_instruktsiy_kak_sohranyat_kontrol_nad_avtonomnymi_ai_agentami',
];

return [
    /*
     * Layout for /blog index page.
     * Supported: classic | masonry
     */
    'index_layout' => env('BLOG_INDEX_LAYOUT', 'classic'),

    /*
     * Items per page for /blog.
     */
    'per_page' => (int) env('BLOG_INDEX_PER_PAGE', 10),

    /*
     * Character limits for cards.
     */
    'excerpt_limit' => (int) env('BLOG_INDEX_EXCERPT_LIMIT', 90),
    'link_url_limit' => (int) env('BLOG_INDEX_LINK_URL_LIMIT', 50),

    // Used by the article hero kicker (см. resources/views/blog/article/header.blade.php).
    'scrum_ai_series_slugs' => $scrumAiSeriesSlugs,

    /*
     * Card color coding per series on listing pages.
     * css — modifier class on .card-article-wide (styles in custom.css).
     */
    'article_series_cards' => [
        'scrum-events' => [
            'slugs' => $scrumAiSeriesSlugs,
            'label_ru' => 'AI-практика',
            'label_en' => 'AI field notes',
            'css' => 'card-article--ai',
        ],
        'scrum-safe' => [
            'slugs' => $scrumSafeSeriesSlugs,
            'label_ru' => 'Практика Scrum и SAFe',
            'label_en' => 'Scrum & SAFe in practice',
            'css' => 'card-article--scrum-safe',
        ],
        'ai-agents' => [
            'slugs' => $aiAgentsSeriesSlugs,
            'label_ru' => 'AI-агенты в работе',
            'label_en' => 'AI agents at work',
            'css' => 'card-article--ai-agents',
        ],
    ],
];


