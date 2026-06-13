<div class="d-flex flex-wrap align-items-center mb-4">
    <a href="{{ route('admin.index') }}" class="btn btn-outline-primary btn-sm mr-2 mb-2">Главная админки</a>
    <a href="{{ route('admin.article_feedback.index') }}" class="btn btn-outline-primary btn-sm mr-2 mb-2">Ответы по статьям</a>
    <a href="{{ route('admin.article_analytics.index') }}" class="btn btn-outline-primary btn-sm mr-2 mb-2">Аналитика чтения</a>
    <a href="{{ route('admin.mailing_subscribers.index') }}" class="btn btn-outline-primary btn-sm mr-2 mb-2">Подписчики</a>
    <a href="{{ route('admin.personal_link_visits.index') }}" class="btn btn-outline-primary btn-sm mr-2 mb-2">Короткие ссылки</a>
    <a href="{{ route('admin.site_page_visits.index') }}" class="btn btn-outline-primary btn-sm mr-2 mb-2">Просмотры страниц</a>
    <form action="{{ route('logout') }}" method="post" class="mb-2">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">Выйти</button>
    </form>
</div>
