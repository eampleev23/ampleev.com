@extends('layouts.app')

@section('title', $blog_section->title . ' | Блог')

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
                <div class="col">
                    <h1 class="h2 mb-4">{{ $blog_section->title }}</h1>
                </div>
            </div>

            <div class="row blog-masonry-grid">
                <div class="col-12 col-md-6 col-lg-4 blog-masonry-sizer"></div>

                @foreach($items as $item)
                    <div class="col-12 col-md-6 col-lg-4 mb-4 blog-masonry-item">
                        <div class="card card-article">
                            <a href="{{ route('blog.show_article', $item->text_url) }}">
                                <img src="{{ $item->getPreviewImagePath() }}" alt="{{ $item->title }}" class="card-img-top">
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
                                        <img class="icon icon-sm bg-primary mr-1" src="/assets/img/icons/theme/communication/group.svg"
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
                @endforeach
            </div>

            {!! $items->links('blog.articles.pagination') !!}
        </div>
    </section>

    @include('blog.articles.emailing_list_footer')
@endsection

@section('pageScript')
    @parent
    <script type="text/javascript">
        window.addEventListener('load', function () {
            if (typeof Isotope === 'undefined') return;
            var grid = document.querySelector('.blog-masonry-grid');
            if (!grid) return;
            new Isotope(grid, {
                itemSelector: '.blog-masonry-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.blog-masonry-sizer'
                }
            });
        });
    </script>
@endsection
