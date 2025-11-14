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
    @include('layouts.navbar')
    <section class="bg-dark text-light header-inner p-0 jarallax o-hidden" data-overlay="" data-jarallax=""
             data-speed="0.2" style="padding-top: 69.2656px !important;">
    <header>
    <h1>Евгений Амплеев</h1>
    <p>Руководитель IT-направления / Директор по разработке</p>
    </header>

    <main>
        <!-- Секция 1: Контакты -->
        <section>
            <h2>Контакты</h2>
            <ul>
                <li>Телефон: +7 995 783-22-77</li>
                <li>Email: e@mpleev.com (предпочитаемый способ связи)</li>
                <li>Telegram: @mpleeve</li>
            </ul>
        </section>
    </main>
    </section>
@endsection

@section('pageScript')
    @parent
@endsection
