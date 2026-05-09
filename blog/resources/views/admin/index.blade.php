@extends('layouts.app')

@section('title', 'Админка')

@section('content')
    <section class="bg-primary-alt header-inner o-hidden">
        <div class="container">
            <div class="row my-4">
                <div class="col">
                    <h1>Админка</h1>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @include('admin.partials.nav')

            <div class="row">
                @foreach($sections as $section)
                    <div class="col-md-6 mb-4">
                        <a href="{{ $section['url'] }}" class="card card-body h-100">
                            <h3>{{ $section['title'] }}</h3>
                            <p class="mb-0 text-muted">{{ $section['description'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
