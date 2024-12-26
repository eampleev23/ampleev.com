@switch($active_menu_item)
    @case('Обо мне')

    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a href="#" class="nav-link active"
               aria-expanded="false" aria-haspopup="true">Обо мне</a>
        </li>

{{--        <li class="nav-item dropdown">--}}
{{--            <a href="{{route('blog.blog')}}" class="nav-link"--}}
{{--               aria-expanded="true" aria-haspopup="true">Блог</a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link"
               aria-expanded="true" aria-haspopup="true">Правила</a>
        </li>

    </ul>

    @break
    @case('Блог')
    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a href="{{route('static_pages.about_me')}}" class="nav-link"
               aria-expanded="false" aria-haspopup="true">Обо мне</a>
        </li>

{{--        <li class="nav-item dropdown">--}}
{{--            <a href="#" class="nav-link active"--}}
{{--               aria-expanded="true" aria-haspopup="true">Блог</a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link"
               aria-expanded="true" aria-haspopup="true">Правила</a>
        </li>

    </ul>
    @break

    @case('Блог_статья')
    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a href="{{route('static_pages.about_me')}}" class="nav-link"
               aria-expanded="false" aria-haspopup="true">Обо мне</a>
        </li>

{{--        <li class="nav-item dropdown">--}}
{{--            <a href="{{route('blog.blog')}}" class="nav-link active"--}}
{{--               aria-expanded="true" aria-haspopup="true">Блог</a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link"
               aria-expanded="true" aria-haspopup="true">Правила</a>
        </li>

    </ul>
    @break

    @case('Правила')
    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a href="{{route('static_pages.about_me')}}" class="nav-link"
               aria-expanded="false" aria-haspopup="true">Обо мне</a>
        </li>

{{--        <li class="nav-item dropdown">--}}
{{--            <a href="{{route('blog.blog')}}" class="nav-link"--}}
{{--               aria-expanded="true" aria-haspopup="true">Блог</a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown">
            <a href="#" class="nav-link active"
               aria-expanded="true" aria-haspopup="true">Правила</a>
        </li>

    </ul>
    @break

    @default
    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a href="{{route('static_pages.about_me')}}" class="nav-link"
               aria-expanded="false" aria-haspopup="true">Обо мне</a>
        </li>

{{--        <li class="nav-item dropdown">--}}
{{--            <a href="{{route('blog.blog')}}" class="nav-link"--}}
{{--               aria-expanded="true" aria-haspopup="true">Блог</a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link"
               aria-expanded="true" aria-haspopup="true">Правила</a>
        </li>

    </ul>
@endswitch
