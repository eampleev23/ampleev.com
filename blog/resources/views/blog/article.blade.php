<!-- Stored in resources/views/child.blade.php -->
@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route('blog.show_article', $article->id))
@section('main_image_path', env('APP_URL').$article->main_image_path)

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection

@section('content')
    @include('layouts.navbar_white')
    @include('blog.article.article_progress')
    @include('blog.article.breadcrumb_and_views')

    <section class="p-0" data-reading-position>
        <div class="container">
            <div class="row justify-content-center position-relative">
                <div class="col-lg-10 col-xl-8">
                    <div class="popover-image">

                        <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 15%; left: 12%;"
                             data-toggle="tooltip" data-placement="bottom"
                             title="Зафиксирован объем работ на спринт в результате мероприятия Sprint Planning">

                        </div>

                        <div class="popover-hotspot bg-primary-2" style="top: 39%; left: 48%;" data-toggle="tooltip"
                             data-placement="bottom"
                             title="Количество фактически невыполненной работы на текущий момент времени.">

                        </div>

                        <div class="popover-hotspot bg-primary-2" style="top: 52%; left: 48%;" data-toggle="tooltip"
                             data-placement="bottom"
                             title="Количество не выполненной работы в текущий момент в идеале (если выполнять каждый день по одинаковому количеству работы и успеть всё запланированное в последний день спринта)">

                        </div>
                        <img src="assets/img/article-5_my.jpg" alt="Image" class="rounded border shadow-lg">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
    </section>

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <hr>
                    @include('blog.article.social_sharing')
                    @include('blog.article.comments')
                    @include('blog.article.answer_form')
                    <hr id="add_comment">
                    @include('blog.article.add_comment')

                </div>
            </div>
        </div>
        <div class="divider">
            <img class="bg-primary-alt" src="assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>
        </div>
    </section>

    @include('blog.article.related_stories')

@endsection

@section('pageScript')
    @parent
@endsection