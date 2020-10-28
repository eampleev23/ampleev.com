<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title')
    @parent
    Все посты раздела {{$blog_section->title}} | Блог
@endsection

@section('custom_css')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
@endsection

{{--@section('sidebar')--}}
{{--    @parent--}}
    {{--    <p>This is appended to the master sidebar.</p>--}}
{{--@endsection--}}



@section('content')
    @include('layouts.navbar')
    @include('blog.articles.index_head')

    <section data-overlay>
        <div class="container">
            <div class="row mb-4">
                @include('blog.articles.list_items')
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                    @include('blog.articles.mailing_lists')
                    {{--                    @include('blog.articles.popular')--}}
                    @include('blog.articles.advertising')
                </div>
            </div>
        </div>
    </section>
    @include('blog.articles.emailing_list_footer')
@endsection
@section('pageScript')
    @parent
@endsection

