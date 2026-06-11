@php
    use App\Support\SiteLocale;

    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $site_locale ?? 'ru');
@endphp

<div class="col-md-8 col-lg-9">
    @foreach($items as $item)
        @switch($item->type_article)
            @case('article')
            @php
                $itemSectionTitle = trim((string) optional($item->blog_section)->title);
                $itemIsAi = strcasecmp($itemSectionTitle, 'AI') === 0;
                $itemSeriesLabel = ($site_locale ?? 'ru') === 'en' ? 'AI field notes' : 'AI-практика';
            @endphp
            <div class="pr-lg-4">
                <div class="card card-article-wide article-card-clickable flex-md-row no-gutters {{ $itemIsAi ? 'card-article--ai' : '' }}">
                    <a href="{{ route($articleRoute, $item->getRouteTextUrl($site_locale ?? 'ru')) }}" class="col-md-4">
                        <img src="{{$item->getPreviewImagePath()}}" alt="Image" class="card-img-top">
                    </a>
                    <div class="card-body d-flex flex-column col-auto p-4">
                        @if($itemIsAi)
                            <div class="article-card-series-badge">{{ $itemSeriesLabel }}</div>
                        @endif
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex article-card-meta">
                                <div class="mr-2">
                                    <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $item->blog_section->title)) }}">{{$item->blog_section->short_title_for_display}}</a>
                                </div>
                                <span class="text-muted">{{$item->get_nice_day_created()}}</span>
                            </div>
                            <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                  title
                                  data-original-title="{{ $locale_labels['unique_views'] ?? 'Количество уникальных просмотров' }}">
                      <img class="icon icon-sm bg-primary mr-1 view-count-icon" src="/assets/img/icons/theme/communication/group.svg"
                           alt="visible icon"
                           data-inject-svg/>{{$item->views_count}}
                    </span>
                        </div>
                        <a href="{{ route($articleRoute, $item->getRouteTextUrl($site_locale ?? 'ru')) }}" class="flex-grow-1 article-card-main-link stretched-link">
                            <h3>{!!$item->html_title!!}</h3>
                        </a>
                        <div class="d-flex align-items-center mt-3">
                            <img src="{{config('app.url').$item->user->avatar_path}}" alt="Image"
                                 class="avatar avatar-sm">
                            <div class="ml-1">
                                <span class="text-small">{{$item->user->name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
            @case('link')
            <div class="pr-lg-4">
                <noindex><a rel="nofollow noopener noreferrer" target="_blank" href="{{$item->text_url}}"
                            class="card card-body justify-content-between bg-primary text-light">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex">
                                <div class="mr-2">
                                    {{ $locale_labels['links'] ?? 'Ссылки' }}
                                </div>
                                <span class="opacity-70">{{$item->get_nice_day_created()}}</span>
                            </div>
                            <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                  title
                                  data-original-title="{{ $locale_labels['unique_views'] ?? 'Количество уникальных просмотров' }}">
                                <img class="icon icon-sm bg-primary mr-1 view-count-icon" src="/assets/img/icons/theme/communication/group.svg"
                                     alt="visible icon"
                                     data-inject-svg/>{{$item->views_count}}
                            </span>
                        </div>
                        <div>
                            <h2>{!!$item->html_title!!}</h2>
                            <span class="text-small opacity-70">{{ \Illuminate\Support\Str::limit($item->text_url, config('blog.link_url_limit', 50)) }}</span>
                        </div>
                    </a></noindex>
            </div>
            @break
            @case('qoute')
            <div class="pr-lg-4">
                <div class="card card-body justify-content-between bg-primary-2 text-light">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-small d-flex">
                            <div class="mr-2">
                                <a href="#">{{ $locale_labels['quotes'] ?? 'Цитаты' }}</a>
                            </div>
                            <span class="opacity-70">{{$item->get_nice_day_created()}}</span>
                        </div>
                        {{--                        <span class="badge bg-primary text-light">--}}
                        {{--                    <img class="icon icon-sm bg-white" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"--}}
                        {{--                         alt="heart interface icon" data-inject-svg="">{{$items[$i]->views_count}}--}}
                        {{--                  </span>--}}
                    </div>
                    <div>
                        <h2>&#171;{!!$item->html_title!!}&#187;</h2>
                        <span class="text-small opacity-70">– {{$item->first_paragraph}}</span>
                    </div>
                </div>
            </div>
            @break
            @default
            <div></div>
        @endswitch
    @endforeach
</div>
