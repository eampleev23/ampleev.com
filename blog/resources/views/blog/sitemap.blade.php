<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach ($articles as $article)
        @php
            $enTranslation = $article->translation(\App\Support\SiteLocale::EN);
            $ruUrl = route('blog.show_article', $article->getRouteTextUrl(\App\Support\SiteLocale::RU));
            $enUrl = $enTranslation
                ? route('en.blog.show_article', $article->getRouteTextUrl(\App\Support\SiteLocale::EN))
                : null;
            $locUrl = (($locale ?? 'ru') === \App\Support\SiteLocale::EN && $enUrl) ? $enUrl : $ruUrl;
            // Перевод может обновляться независимо от базовой статьи — берём максимум.
            $lastmod = $article->updated_at;
            if ($enTranslation && $enTranslation->updated_at && $enTranslation->updated_at->gt($lastmod)) {
                $lastmod = $enTranslation->updated_at;
            }
        @endphp
        <url>
            <loc>{{ $locUrl }}</loc>
            @if($enUrl)
            <xhtml:link rel="alternate" hreflang="ru" href="{{ $ruUrl }}"/>
            <xhtml:link rel="alternate" hreflang="en" href="{{ $enUrl }}"/>
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ $enUrl }}"/>
            @endif
            <lastmod>{{ $lastmod->tz('GMT')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
</urlset>
