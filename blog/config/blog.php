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
];


