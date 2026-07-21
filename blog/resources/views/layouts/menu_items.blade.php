@php
    use App\Support\SiteLocale;

    $locale = $site_locale ?? SiteLocale::RU;
    $blogRoute = SiteLocale::routeNameForLocale('blog.blog', $locale);
    $contactRoute = SiteLocale::routeNameForLocale('static_pages.contact', $locale);
    $termsRoute = SiteLocale::routeNameForLocale('docs.terms_of_use', $locale);
    $aboutRoute = SiteLocale::routeNameForLocale('static_pages.about_me', $locale);
    $yaiRoute = SiteLocale::routeNameForLocale('static_pages.yai', $locale);
    $activeItem = $active_menu_item ?? '';
@endphp

<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a href="{{ route($blogRoute) }}"
           class="nav-link {{ in_array($activeItem, ['Блог', 'Блог_статья'], true) ? 'active' : '' }}"
           aria-expanded="true" aria-haspopup="true">{{ $locale_labels['blog'] }}</a>
    </li>

    <li class="nav-item dropdown">
        <a href="{{ route($yaiRoute) }}"
           class="nav-link {{ $activeItem === 'ЯAI' ? 'active' : '' }}"
           aria-expanded="true" aria-haspopup="true">{{ $locale_labels['yai'] }}</a>
    </li>

    <li class="nav-item dropdown">
        <a href="{{ route($contactRoute) }}"
           class="nav-link {{ $activeItem === 'Контакты' ? 'active' : '' }}"
           aria-expanded="true" aria-haspopup="true">{{ $locale_labels['contacts'] }}</a>
    </li>

    <li class="nav-item dropdown">
        <a href="{{ route($termsRoute) }}"
           class="nav-link {{ $activeItem === 'Правила' ? 'active' : '' }}"
           aria-expanded="true" aria-haspopup="true">{{ $locale_labels['terms'] }}</a>
    </li>

    <li class="nav-item dropdown">
        <a href="{{ route($aboutRoute) }}"
           class="nav-link {{ $activeItem === 'Обо мне' ? 'active' : '' }}"
           aria-expanded="false" aria-haspopup="true">{{ $locale_labels['about_me'] }}</a>
    </li>
</ul>
