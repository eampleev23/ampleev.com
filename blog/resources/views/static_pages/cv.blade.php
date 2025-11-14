@extends('layouts.app')

@section('title', 'Резюме - Руководитель IT-направления')
@section('description', 'Амплеев Евгений Михайлович')
@section('page_url', route('static_pages.cv'))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')

@endsection

@section('pageScript')
    @parent
@endsection
