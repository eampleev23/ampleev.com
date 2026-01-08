@extends('layouts.app')

@section('title', 'Блог')

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
    @include('blog.articles.index_head')

    <section data-overlay>
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div>
                        @foreach($groupedArticles as $section)
                            <div class="mb-5">
                                @if($section['title'])
                                    <h2 class="mb-4">{{ $section['title'] }}</h2>
                                @endif
                                <div class="row blog-masonry-grid">
                                    <div class="col-12 col-md-6 col-lg-4 blog-masonry-sizer"></div>
                                    @foreach($section['articles'] as $item)
                                        @switch($item->type_article)
                                            @case('link')
                                                <div class="col-12 col-md-6 col-lg-4 mb-4 blog-masonry-item">
                                                    <noindex>
                                                        <a rel="nofollow noopener noreferrer" target="_blank"
                                                           href="{{ $item->text_url }}"
                                                           class="card card-body justify-content-between bg-primary text-light">
                                                            <div class="d-flex justify-content-between mb-3">
                                                                <div class="text-small d-flex">
                                                                    <div class="mr-2">Ссылки</div>
                                                                    <span class="opacity-70">{{ $item->get_nice_day_created() }}</span>
                                                                </div>
                                                                <span class="badge bg-primary-alt text-primary"
                                                                      data-toggle="tooltip" data-placement="top"
                                                                      title data-original-title="Количество уникальных просмотров">
                                                                    <img class="icon icon-sm bg-primary mr-1" src="/assets/img/icons/theme/general/visible.svg"
                                                                         alt="visible icon" style="transform: scale(1.3);" data-inject-svg/>
                                                                    {{ $item->views_count }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h2>{!! $item->html_title !!}</h2>
                                                                <span class="text-small opacity-70">
                                                                    {{ \Illuminate\Support\Str::limit($item->text_url, config('blog.link_url_limit', 50)) }}
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </noindex>
                                                </div>
                                                @break

                                            @case('article')
                                                <div class="col-12 col-md-6 col-lg-4 mb-4 blog-masonry-item">
                                                    <div class="card card-article">
                                                        <a href="{{ route('blog.show_article', $item->text_url) }}">
                                                            <img src="{{ $item->main_image_path }}" alt="{{ $item->title }}" class="card-img-top">
                                                        </a>
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between mb-3">
                                                                <div class="text-small d-flex">
                                                                    <div class="mr-2">
                                                                        <a href="{{ route('blog.show_blog_section', str_replace('/', '_SLASH_', $item->blog_section->title)) }}">
                                                                            {{ $item->blog_section->short_title_for_display }}
                                                                        </a>
                                                                    </div>
                                                                    <span class="text-muted">{{ $item->get_nice_day_created() }}</span>
                                                                </div>
                                                                <span class="badge bg-primary-alt text-primary"
                                                                      data-toggle="tooltip" data-placement="top"
                                                                      title data-original-title="Количество уникальных просмотров">
                                                                    <img class="icon icon-sm bg-primary mr-1" src="/assets/img/icons/theme/general/visible.svg"
                                                                         alt="visible icon" style="transform: scale(1.3);" data-inject-svg/>
                                                                    {{ $item->views_count }}
                                                                </span>
                                                            </div>

                                                            <a href="{{ route('blog.show_article', $item->text_url) }}" class="d-block">
                                                                <h3>{!! $item->html_title !!}</h3>
                                                            </a>

                                                            @php
                                                                $excerpt = trim(strip_tags($item->first_paragraph ?: $item->seo_description));
                                                                $excerpt = \Illuminate\Support\Str::limit($excerpt, config('blog.excerpt_limit', 90), '..');
                                                            @endphp
                                                            @if($excerpt)
                                                                <p class="mb-0 text-muted">{{ $excerpt }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('blog.articles.emailing_list_footer')
@endsection

@section('pageScript')
    @parent
    <script type="text/javascript">
        window.addEventListener('load', function () {
            if (typeof Isotope === 'undefined') return;
            var grids = document.querySelectorAll('.blog-masonry-grid');
            grids.forEach(function(grid) {
                new Isotope(grid, {
                    itemSelector: '.blog-masonry-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.blog-masonry-sizer'
                    }
                });
            });
        });
    </script>
@endsection


