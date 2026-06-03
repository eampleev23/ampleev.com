@php
    use App\Support\SiteLocale;

    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $site_locale ?? 'ru');
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $site_locale ?? 'ru');
@endphp

<section class="bg-primary-alt">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h3 class="h2">{{ $locale_labels['related_stories'] ?? 'Возможно, вам будет интересно' }}</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            @for($i=0; $i < count($random_articles); $i++)
                <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="card card-article article-card-clickable">
                        <a href="{{ route($articleRoute, $random_articles[$i]->getRouteTextUrl($site_locale ?? 'ru')) }}">
                            <img src="{{$random_articles[$i]->getPreviewImagePath()}}" alt="{{$random_articles[$i]->title}}" class="card-img-top" width="600" height="338" loading="lazy" decoding="async">
                        </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-small d-flex article-card-meta">
                                    <div class="mr-2">
                                        <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $random_articles[$i]->blog_section->title)) }}">
                                            {{$random_articles[$i]->blog_section->short_title_for_display}}
                                        </a>
                                    </div>
                                    <span class="text-muted">{{$random_articles[$i]->get_nice_day_created()}}</span>
                                </div>
                                <span class="badge bg-primary-alt text-primary">
                                <img class="icon icon-sm bg-primary mr-1 view-count-icon"
                                     src="/assets/img/icons/theme/communication/group.svg"
                                     alt=""
                                     aria-hidden="true"
                                     data-inject-svg/>{{$random_articles[$i]->views_count}}
                              </span>
                            </div>
                            <a href="{{ route($articleRoute, $random_articles[$i]->getRouteTextUrl($site_locale ?? 'ru')) }}" class="article-card-main-link stretched-link">
                                <h4>{!!$random_articles[$i]->html_title!!}</h4>
                            </a>
                            @php
                                $excerpt = trim(strip_tags($random_articles[$i]->first_paragraph ?: $random_articles[$i]->seo_description));
                                $excerpt = \Illuminate\Support\Str::limit($excerpt, config('blog.excerpt_limit', 90), '..');
                            @endphp
                            @if($excerpt)
                                <p class="mb-0 text-muted">{{ $excerpt }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
