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
    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.5" data-overlay>
    </section>

    <section>
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row align-items-center justify-content-around">
                <div class="col-12">
                    <h1>Points Counter</h1>
                    <p>Страница находится в разработке</p>
                </div>
            </div>
        </div>
    </section>
@endsection

