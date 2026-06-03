@php
    use App\Support\SiteLocale;

    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $site_locale ?? 'ru');
@endphp

<div class="mb-4">
    <h5>{{ $locale_labels['popular_in_blog'] ?? 'Популярное в блоге' }}</h5>
    <ul class="list-unstyled list-articles">
        @for($i=0; $i < count($top_articles); $i++)
            <li class="row row-tight">
                <a href="{{ route($articleRoute, $top_articles[$i]->getRouteTextUrl($site_locale ?? 'ru')) }}"
                   class="col-3">
                    <img src="{{$top_articles[$i]->getPreviewImagePath()}}" alt="{{$top_articles[$i]->title}}" class="rounded" width="96" height="64" loading="lazy" decoding="async">
                </a>
                <div class="col">
                    <a href="{{ route($articleRoute, $top_articles[$i]->getRouteTextUrl($site_locale ?? 'ru')) }}">
                        <h6 class="mb-1">{!!$top_articles[$i]->html_title!!}</h6>
                    </a>
                    <div class="d-flex text-small">
                        <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $top_articles[$i]->blog_section->title)) }}">{{$top_articles[$i]->blog_section->title}}</a>
                        <span class="text-muted ml-1">{{$top_articles[$i]->get_nice_time_created()}}</span>
                    </div>
                </div>
            </li>
        @endfor
    </ul>
</div>
