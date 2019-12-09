<!-- Stored in resources/views/child.blade.php -->

@php
    /**
      * @var $article Article
      **/
@endphp

@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route('blog.show_article', $article->id))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection

@section('content')