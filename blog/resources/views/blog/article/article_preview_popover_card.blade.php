@php
    use App\Support\SiteLocale;

    /** @var \App\Article $previewArticle */
    $previewArticleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $previewSectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $site_locale ?? 'ru');
    $previewArticleUrl = route($previewArticleRoute, $previewArticle->getRouteTextUrl($site_locale ?? 'ru'));
    $previewExcerpt = trim(strip_tags($previewArticle->first_paragraph ?: $previewArticle->seo_description));
    $previewExcerpt = \Illuminate\Support\Str::limit($previewExcerpt, config('blog.excerpt_limit', 90), '..');
@endphp
<div class="card card-article article-preview-popover-card article-card-clickable">
    <a class="article-preview-popover-image" href="{{ $previewArticleUrl }}" target="_blank" rel="noopener noreferrer">
        <img src="{{ $previewArticle->getPreviewImagePath() }}" alt="{{ $previewArticle->title }}" class="card-img-top" width="600" height="338" loading="lazy" decoding="async">
    </a>
    <div class="card-body article-preview-popover-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="text-small d-flex">
                <div class="mr-2">
                    <a href="{{ route($previewSectionRoute, str_replace('/', '_SLASH_', $previewArticle->blog_section->title)) }}" target="_blank" rel="noopener noreferrer">
                        {{ $previewArticle->blog_section->short_title_for_display }}
                    </a>
                </div>
                <span class="text-muted">{{ $previewArticle->get_nice_day_created() }}</span>
            </div>
            <span class="badge bg-primary-alt text-primary"
                  data-toggle="tooltip"
                  data-placement="top"
                  title
                  data-original-title="{{ $locale_labels['unique_views'] ?? 'Количество уникальных просмотров' }}">
                <img class="icon icon-sm bg-primary mr-1 view-count-icon"
                     src="/assets/img/icons/theme/communication/group.svg"
                     alt=""
                     aria-hidden="true"
                     data-inject-svg/>
                {{ $previewArticle->views_count }}
            </span>
        </div>

        <a href="{{ $previewArticleUrl }}" target="_blank" rel="noopener noreferrer" class="d-block article-card-main-link stretched-link">
            <h3>{!! $previewArticle->html_title !!}</h3>
        </a>

        @if($previewExcerpt)
            <p class="mb-0 text-muted">{{ $previewExcerpt }}</p>
        @endif
    </div>
</div>
