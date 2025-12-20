@extends('layouts.app')

@section('title', 'Мой профиль')
@section('description', 'Профиль пользователя')
@section('page_url', route('user.profile'))

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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row mb-4">
                        <div class="col">
                            <h1 data-aos="fade-up">Мой профиль</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Раздел: Аватарка -->
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="{{ $user->avatar_path ? (str_starts_with($user->avatar_path, 'http') ? $user->avatar_path : env('APP_URL') . $user->avatar_path) : '/storage/user_avatars/default.jpg' }}" 
                                         alt="{{ $user->name }}" 
                                         class="avatar avatar-lg mb-3">
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Раздел: Личная информация -->
                        <div class="col-md-8 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-4">Личная информация</h4>
                                    
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Имя</dt>
                                        <dd class="col-sm-8">{{ $user->name ?? 'Не указано' }}</dd>

                                        <dt class="col-sm-4">Email</dt>
                                        <dd class="col-sm-8">{{ $user->email ?? 'Не указано' }}</dd>

                                        <dt class="col-sm-4">Дата регистрации</dt>
                                        <dd class="col-sm-8">{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : 'Не указано' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Раздел: Настройки уведомлений -->
                    <div class="row">
                        <div class="col-12 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-4">Настройки</h4>
                                    
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Уведомления о комментариях</dt>
                                        <dd class="col-sm-8">
                                            @if($user->comment_notifications_enabled)
                                                <span class="badge badge-success">Включены</span>
                                            @else
                                                <span class="badge badge-secondary">Отключены</span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

