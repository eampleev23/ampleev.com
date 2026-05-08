@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $routeName = SiteLocale::routeNameForLocale('static_pages.economy_sim', $currentLocale);
    $ruUrl = route('static_pages.economy_sim');
    $enUrl = route('en.static_pages.economy_sim');
    $locale_switch_urls = [
        'ru' => $ruUrl,
        'en' => $enUrl,
    ];
@endphp

@extends('layouts.app')

@section('title', 'Экономика страны — симулятор')
@section('description', 'Интерактивный симулятор упрощённой экономики с яблоками, деньгами и потребителями.')
@section('page_url', route($routeName))
@section('canonical_url', route($routeName))
@section('alternate_url_ru', $ruUrl)
@section('alternate_url_en', $enUrl)
@section('x_default_url', $ruUrl)

@section('custom_css')
    @parent
    <link href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="{{ asset('assets/css/economy-sim.css') }}?v={{ filemtime(public_path('assets/css/economy-sim.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])

    <section class="bg-primary-alt pb-0">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-8 col-lg-10">
                    <span class="badge badge-primary">Симулятор</span>
                    <h1 class="mt-3 mb-3">Упрощённая экономика с яблоками</h1>
                    <p class="lead mb-0">
                        Скрытый исследовательский прототип: фермер выращивает яблоки, везёт их на рынок,
                        потребители получают доход, покупают еду и выживают или умирают от голода.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-4">
        <div class="container-fluid px-lg-5">
            <div id="economy-sim-root"
                 data-economy-sim-root
                 data-locale="{{ $currentLocale }}"></div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
    <script type="text/javascript" src="{{ asset('js/economy-sim.js') }}?v={{ filemtime(public_path('js/economy-sim.js')) }}"></script>
@endsection
