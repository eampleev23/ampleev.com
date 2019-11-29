<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Главная страница')

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection

@section('content')
    <section class="min-vh-100 bg-primary-3 text-light py-5 o-hidden">
        <div class="container">
            <div class="row justify-content-center mb-md-6">
                <div class="col-auto">
                    {{--                <a href="index.html">--}}
                    {{--                    <img src="assets/img/logo-white.svg" alt="Leap">--}}
                    {{--                </a>--}}
                </div>
            </div>
            <div class="row text-center py-6">
                <div class="col layer-2">
                    {{--                    <h1 class="display-1 mb-0">[ A ]mpleev.com</h1>--}}
                    <h3 class="display-1 mb-0">

                        <span data-typed-text data-loop="true"
                              data-type-speed="100"
                              data-back-speed="100"
                              data-show-cursor="true"
                              data-bind-input-focus-events="true"
                              data-strings='["a", "@", "e@"]'></span>
                        <span>mpleev.com</span>
                    </h3>
                    <br/>
                    <br/>
                    <h4 class="h1">Сайт в разработке</h4>
                    {{--                <div class="lead mb-4"></div>--}}
                    {{--                <a class="btn btn-primary btn-lg" href="index.html">Go back to home</a>--}}
                </div>
            </div>
        </div>
        <div class="decoration-wrapper d-none d-md-block">
            {{--        <div class="decoration right middle-y scale-2" data-jarallax-element="200">--}}
            {{--            <img class="bg-primary-2" src="assets/img/decorations/deco-blob-3.svg" alt="deco-blob-3 decoration" data-inject-svg />--}}
            {{--        </div>--}}
            {{--        <div class="decoration right middle-y" data-jarallax-element="100">--}}
            {{--            <img class="bg-primary" src="assets/img/decorations/deco-lines-3.svg" alt="deco-lines-3 decoration" data-inject-svg />--}}
            {{--        </div>--}}
            {{--        <div class="decoration top left scale-3" data-jarallax-element="50">--}}
            {{--            <img class="bg-white" src="assets/img/decorations/deco-blob-9.svg" alt="deco-blob-9 decoration" data-inject-svg />--}}
            {{--        </div>--}}
            {{--        <div class="decoration top left scale-2 scale-3 blend-mode-multiply" data-jarallax-element="150 50">--}}
            {{--            <img class="bg-primary-2" src="assets/img/decorations/deco-dots-2.svg" alt="deco-dots-2 decoration" data-inject-svg />--}}
            {{--        </div>--}}
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
    <script>
        window.onload = function () {

            setInterval(() => addTextUpdate(), 200);

            let addTextUpdate = function () {

                // console.log(1);
                let dynamicContent = document.getElementById('dynamicText').innerHTML;

                switch (dynamicContent) {
                    case '@':
                        document.getElementById('staticText').textContent = "mpleev - my instagram";
                        break;

                    case 'e@':
                        document.getElementById('staticText').textContent = "mpleev.com - my mail";
                        break;

                    case 'a':
                        document.getElementById('staticText').textContent = "mpleev.com - my site";
                        break;

                }

                // let staticContent = document.getElementById('staticText').innerHTML;
                // console.log("dynamicContent", dynamicContent);
                // console.log("staticContent", staticContent);
            }

        }
    </script>
@endsection
