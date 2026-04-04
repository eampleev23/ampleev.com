@php
    use App\Support\SiteLocale;

    $locale = $site_locale ?? 'ru';
    $blogRoute = SiteLocale::routeNameForLocale('blog.blog', $locale);
    $contactRoute = SiteLocale::routeNameForLocale('static_pages.contact', $locale);
    $termsRoute = SiteLocale::routeNameForLocale('docs.terms_of_use', $locale);
    $aboutRoute = SiteLocale::routeNameForLocale('static_pages.about_me', $locale);
@endphp
@switch($active_menu_item)
@case('Обо мне')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route($blogRoute)}}" class="nav-link">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($contactRoute)}}" class="nav-link">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($termsRoute)}}" class="nav-link">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link active">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
</ul>

@break
@case('Блог')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="#" class="nav-link active">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($contactRoute)}}" class="nav-link">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($termsRoute)}}" class="nav-link">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($aboutRoute)}}" class="nav-link">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
</ul>
@break

@case('Блог_статья')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route($blogRoute)}}" class="nav-link active">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($contactRoute)}}" class="nav-link">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($termsRoute)}}" class="nav-link">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($aboutRoute)}}" class="nav-link">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
</ul>
@break
@case('Контакты')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route($blogRoute)}}" class="nav-link">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link active">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($termsRoute)}}" class="nav-link">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($aboutRoute)}}" class="nav-link">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
</ul>
@break
@case('Правила')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route($blogRoute)}}" class="nav-link">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($contactRoute)}}" class="nav-link">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link active">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($aboutRoute)}}" class="nav-link">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
</ul>
@break
@case('Продукты')
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route($blogRoute)}}" class="nav-link">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($contactRoute)}}" class="nav-link">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($termsRoute)}}" class="nav-link">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($aboutRoute)}}" class="nav-link">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
</ul>
@break

@default
<ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{route($blogRoute)}}" class="nav-link">{{ $locale_labels['blog'] ?? 'Блог' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($contactRoute)}}" class="nav-link">{{ $locale_labels['contacts'] ?? 'Контакты' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($termsRoute)}}" class="nav-link">{{ $locale_labels['terms'] ?? 'Правила' }}</a>
    </li>
    <li class="nav-item">
        <a href="{{route($aboutRoute)}}" class="nav-link">{{ $locale_labels['about_me'] ?? 'Обо мне' }}</a>
    </li>
    </ul>
@endswitch
