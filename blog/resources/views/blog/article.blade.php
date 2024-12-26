@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route('blog.show_article', $article->text_url))
@section('main_image_path', env('APP_URL').$article->main_image_path)

@section('custom_css')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="assets/css/custiom_article.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- here we are-->
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white')
    @include('blog.article.article_progress')
    @include('blog.article.breadcrumb_and_views')

    <section class="p-0" data-reading-position>
        <div class="container">
            <div class="row justify-content-center position-relative">
                <div class="col-lg-10 col-xl-8">
                    {!! $article->first_paragraph !!}
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
    </section>

{{--    <section class="has-divider">--}}
{{--        <div class="container pt-3">--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-xl-7 col-lg-8 col-md-10">--}}

{{--                    <hr>--}}
{{--                    @include('blog.article.social_sharing')--}}
{{--                    @include('blog.article.comments')--}}
{{--                    @include('blog.article.answer_form')--}}
{{--                    <hr id="add_comment">--}}
{{--                    @include('blog.article.add_comment')--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="divider">--}}
{{--            <img class="bg-primary-alt" src="assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    @include('blog.article.related_stories')--}}
{{--    @include('blog.articles.emailing_list_footer')--}}

@endsection

@section('pageScript')
    @parent
@endsection
