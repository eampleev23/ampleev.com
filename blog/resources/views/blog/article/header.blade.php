@php
    $articleLayout = $article->getArticleLayout();
    $isHeroLayout = in_array($articleLayout, ['image-header', 'parallax'], true);
    $heroSectionClass = $articleLayout === 'parallax'
        ? 'bg-dark text-light overlay min-vh-100 d-flex flex-column justify-content-end jarallax article-hero article-hero-parallax'
        : 'bg-dark text-light overlay min-vh-100 d-flex flex-column justify-content-end article-hero article-hero-image-header';
@endphp

@if($isHeroLayout)
    <section class="{{ $heroSectionClass }}" @if($articleLayout === 'parallax') data-jarallax data-speed="0.5" @endif>
        @if($articleLayout === 'parallax')
            <img src="{{ $article->getHeroImagePath() }}" alt="{{ $article->title }}" class="jarallax-img opacity-60">
        @endif
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('blog.blog') }}">Блог</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('blog.show_blog_section', str_replace('/', '_SLASH_', $article->blog_section->title)) }}">{{ $article->blog_section->title }}</a>
                                </li>
                            </ol>
                        </nav>
                        <span class="article-hero-views" data-toggle="tooltip" data-placement="top" title data-original-title="Количество уникальных просмотров">
                            <img class="icon icon-sm mr-2"
                                 src="/assets/img/icons/theme/communication/group.svg"
                                 alt="views icon"
                                 data-inject-svg/>{!! $article->views_count !!}
                        </span>
                    </div>
                    <h1>{!! $article->html_title !!}</h1>
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="{{ env('APP_URL').$article->user->avatar_path }}" alt="Avatar" class="avatar mr-2">
                        </a>
                        <div>
                            <div>Автор статьи: <a href="#">{{ $article->user->name }}</a></div>
                            <div class="text-small text-light-70">{{ $article->get_nice_time_created() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($articleLayout === 'image-header')
            <div class="container pb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <img src="{{ $article->getHeroImagePath() }}" alt="{{ $article->title }}" class="img-fluid rounded border shadow-lg">
                    </div>
                </div>
            </div>
        @endif
    </section>
@else
    @include('blog.article.breadcrumb_and_views', ['article' => $article])
@endif
