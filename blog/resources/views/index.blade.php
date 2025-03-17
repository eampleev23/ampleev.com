<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Блог')

@section('custom_css')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
    <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
@endsection

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection

@section('content')

    <section id="video_background" class="text-light jarallax"
             data-jarallax-video="mp4:./assets/video/video-1.mp4,webm:./assets/video/video-1.webm,ogv:./assets/video/video-1.ogv"
             data-speed="-1.0">
        <div class="container">
            <div class="min-vh-23 align-items-center">
                <div class="col text-center">
                    <h1 id="start_header" class="display-1 mb-0">

                        <span data-typed-text data-loop="true"
                              data-type-speed="100"
                              data-strings='["a", "@", "e@"]'></span>
                        mpleev.com
                    </h1>
                    <br/>
                    <br/>
                    <h6>Амплеев Евгений - Agile Coach / Full stack web developer</h6>
                </div>
            </div>
        </div>
    </section>

{{--    <section class="text-light jarallax" data-jarallax-video="https://www.youtube.com/watch?v=O50AabGiOME" data-video-start-time="30" data-speed="1">--}}
{{--        <div class="container">--}}
{{--            <div class="min-vh-23 align-items-center">--}}
{{--                <div class="col text-center">--}}
{{--                    <h1 id="start_header" class="display-1 mb-0">--}}

{{--                        <span data-typed-text data-loop="true"--}}
{{--                              data-type-speed="100"--}}
{{--                              data-strings='["a", "@", "e@"]'></span>--}}
{{--                        mpleev.com--}}
{{--                    </h1>--}}
{{--                    <br/>--}}
{{--                    <br/>--}}
{{--                    <h6>Амплеев Евгений - Scrum Master / Full stack web developer</h6>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


@endsection

@section('pageScript')
    @parent
@endsection
