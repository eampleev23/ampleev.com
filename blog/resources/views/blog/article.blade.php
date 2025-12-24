@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route('blog.show_article', $article->text_url))
@section('main_image_path', url($article->main_image_path ?: '/assets/img/default-article-image.jpg'))

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="/assets/css/custiom_article.css" rel="stylesheet" type="text/css" media="all"/>
    <style>
        .article figure {
            margin-top: 48px;
        }
    </style>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
    @include('blog.article.article_progress', ['article' => $article])
    @include('blog.article.breadcrumb_and_views', ['article' => $article])

    <section class="p-0" data-reading-position>
        <div class="container">
            <div class="row justify-content-center position-relative">
                <div class="col-lg-10 col-xl-8">
                    <a href="{{ $article->main_image_path }}" data-fancybox="main-image" data-caption="{{ $article->title }}">
                        <img src="{{ $article->main_image_path }}" alt="{{ $article->title }}" class="img-fluid rounded">
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article class="article">
                        {!! $article->first_paragraph !!}
                        {!! $article->content !!}
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <hr>
                    @include('blog.article.social_sharing', ['article' => $article])
                    @include('blog.article.comments', ['article' => $article])
                    @include('blog.article.answer_form', ['article' => $article])
                    <hr id="add_comment">
                    @include('blog.article.add_comment', ['article' => $article])

                </div>
            </div>
        </div>
        <div class="divider">
            <img class="bg-primary-alt" src="/assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>
        </div>
    </section>

    @include('blog.article.related_stories', ['random_articles' => $random_articles, 'random_link' => $random_link])
    @include('blog.articles.emailing_list_footer')

@endsection

@section('pageScript')
    @parent
@endsection
