@php
    use App\Support\SiteLocale;

    $blogRoute = SiteLocale::routeNameForLocale('blog.blog', $site_locale ?? 'ru');
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $site_locale ?? 'ru');
    $aboutRoute = SiteLocale::routeNameForLocale('static_pages.about_me', $site_locale ?? 'ru');
@endphp

<section class="pb-0 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route($blogRoute) }}">{{ $locale_labels['blog'] }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $article->blog_section->title)) }}">{{$article->blog_section->title}}</a>
                            </li>
                        </ol>
                    </nav>
                    <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top" title
                          data-original-title="{{ $locale_labels['unique_views'] ?? 'Количество уникальных просмотров' }}">
                <img class="icon icon-sm bg-primary mr-1 view-count-icon"
                     src="/assets/img/icons/theme/communication/group.svg"
                     alt=""
                     aria-hidden="true"
                     data-inject-svg/>{{$article->views_count}}</span>
                </div>
                <h1>{!!$article->html_title!!}</h1>
                <div class="d-flex align-items-center">
                    <a href="{{ route($aboutRoute) }}" aria-label="{{ $article->user->name }}">
                        <img src="{{env('APP_URL').$article->user->avatar_path}}" alt="" aria-hidden="true" class="avatar mr-2" width="40" height="40" loading="lazy" decoding="async">
                    </a>
                    <div>
                        <div>{{ $locale_labels['author_article'] ?? 'Автор статьи:' }} <a href="{{ route($aboutRoute) }}">{{$article->user->name}}</a>
                        </div>
                        <div class="text-small text-muted">{{$article->get_nice_time_created()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
