@extends('layouts.app')

@section('title', 'Points Counter')
@section('description', 'Points Counter - приложение для подсчета очков')
@section('page_url', 'https://pointscounter.ampleev.com')

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet"
          type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
    
    @include('static_pages.pointscounter._hero')
    @include('static_pages.pointscounter._trusted')
    @include('static_pages.pointscounter._build')
    @include('static_pages.pointscounter._steps')
    @include('static_pages.pointscounter._features')
    @include('static_pages.pointscounter._testimonials')
    @include('static_pages.pointscounter._screenshots')
    @include('static_pages.pointscounter._download')
@endsection
