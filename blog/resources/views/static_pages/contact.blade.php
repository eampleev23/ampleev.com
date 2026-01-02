@extends('layouts.app')

@section('title', 'Связаться')
@section('description', 'Свяжитесь со мной по любым вопросам: email, телефон или форма обратной связи.')
@section('page_url', route('static_pages.contact'))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet"
          type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white')
    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.5" data-overlay>
    </section>

    <section>
        <div class="container aos-init aos-animate" data-aos="fade-up">
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
@endsection
