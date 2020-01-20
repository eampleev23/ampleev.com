<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Вам отправлено письмо для подтверждения подписки')

@section('custom_css')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection



@section('content')

    <section class="min-vh-100-light py-5">
        <div class="container">
            <div class="row justify-content-center mb-md-6">
                <div class="col-auto">
                    <a href="{{route('blog.home')}}">
                        <span>Ampleev.com</span>
                    </a>
                </div>
            </div>
            <div class="row text-center py-6">
                <div class="col">
                    <div class="decoration-check mb-4">
                        <div class="decoration">
                            <img class="bg-primary-2" src="" alt="deco-blob-6 decoration" data-inject-svg="">
                        </div>
                        <img class="icon bg-white" src="" alt="check interface icon" data-inject-svg="">
                    </div>
                    <h2 class="h1">На почту {{$email}} отправлено письмо для подтверждения вашего электронного
                        адреса.</h2>
                    <div class="lead mb-4">Перейдите по ссылке в письме для подтверждения подписки.
                    </div>
                    <a class="btn btn-primary btn-lg" href="{{route('blog.home')}}">Продолжить</a>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('pageScript')
    @parent
@endsection

