@switch($active_menu_item)
@case('Обо мне')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.contact')}}" class="nav-link">Контакты</a>
    </li>
    <li class="nav-item">
        <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link active">Обо мне</a>
    </li>
</ul>

@break
@case('Блог')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="#" class="nav-link active">Блог</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.contact')}}" class="nav-link">Контакты</a>
    </li>
    <li class="nav-item">
        <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
    </li>
</ul>
@break

@case('Блог_статья')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route('blog.blog')}}" class="nav-link active">Блог</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.contact')}}" class="nav-link">Контакты</a>
    </li>
    <li class="nav-item">
        <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
    </li>
</ul>
@break
@case('Контакты')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link active">Контакты</a>
    </li>
    <li class="nav-item">
        <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
    </li>
</ul>
@break
@case('Правила')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.contact')}}" class="nav-link">Контакты</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link active">Правила</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
    </li>
</ul>
@break
@default
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.contact')}}" class="nav-link">Контакты</a>
    </li>
    <li class="nav-item">
        <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
    </li>
    <li class="nav-item">
        <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
    </li>
</ul>
@endswitch
