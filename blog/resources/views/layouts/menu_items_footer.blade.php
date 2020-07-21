<h5>Навигация</h5>

@switch($active_menu_item)
    @case('Обо мне')

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="#" class="nav-link active">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.home')}}" class="nav-link">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            <li class="nav-item">
                <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>
            </li>
        @endguest
    </ul>

    @break
    @case('Блог')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link active">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            <li class="nav-item">
                <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>
            </li>
        @endguest
    </ul>
    @break

    @case('Блог_статья')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.home')}}" class="nav-link active">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            <li class="nav-item">
                <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>
            </li>
        @endguest
    </ul>
    @break

    @case('Правила')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.home')}}" class="nav-link">Блог</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link active">Правила</a>
        </li>
        @guest
            <li class="nav-item">
                <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>
            </li>
        @endguest
    </ul>
    @break

    @default
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.home')}}" class="nav-link">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            <li class="nav-item">
                <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>
            </li>
        @endguest
    </ul>
@endswitch