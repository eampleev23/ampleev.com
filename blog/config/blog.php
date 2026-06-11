<?php

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

    /*
     * Articles of the "AI and Scrum events" series (base RU text_url).
     * Series-specific UI markers (hero kicker badges) are driven by this list,
     * not by blog section: a section can contain articles outside the series.
     */
    'scrum_ai_series_slugs' => [
        'backlog_refinement_i_ai_chto_realno_menyaetsya',
        'ai_assisted_sprint_planning_kak_uskorit_podgotovku_ne_poteryav_otvetstvennost',
        'daily_scrum_i_ai_pochemu_stendap_ne_dolzhen_stat_status_botom',
        'sprint_review_i_ai_pochemu_demo_ne_zamenyaet_razgovor_o_tsennosti',
        'sprint_retrospective_i_ai_pochemu_uluchsheniya_nelzya_delegirovat_modeli',
        'ai_i_scrum_events_chto_realno_menyaetsya_vo_vstrechah_komandy_razrabotki',
    ],
];


