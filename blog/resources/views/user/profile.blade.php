@extends('layouts.app')

@php
    $site_locale = $site_locale ?? \App\Support\SiteLocale::resolve(request());
    $locale_switch_urls = [
        'ru' => route('user.profile'),
        'en' => route('user.profile'),
    ];
@endphp

@section('title', $user->name ?? 'Профиль')

@section('content')
    @include('layouts.navbar_white')

    <section class="bg-primary-alt header-inner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center">
                    @if(!empty($user->avatar_path))
                        <img src="{{ asset($user->avatar_path) }}" alt="" class="avatar avatar-lg mb-3" width="96" height="96" loading="lazy" decoding="async" aria-hidden="true">
                    @endif
                    <h1 class="h2 mb-1">{{ $user->name ?? 'Профиль' }}</h1>
                    <p class="text-muted mb-0">
                        {{ $user->created_at ? 'На сайте с ' . $user->created_at->format('d.m.Y') : 'Профиль пользователя' }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
