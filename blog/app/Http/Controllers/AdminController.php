<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        $sections = [
            [
                'title' => 'Ответы по статьям',
                'description' => 'Статистика feedback-вопросов и таблица отдельных ответов.',
                'url' => route('admin.article_feedback.index'),
            ],
            [
                'title' => 'Аналитика чтения',
                'description' => 'Просмотры, глубина чтения, воронка дочитывания и места отвалов.',
                'url' => route('admin.article_analytics.index'),
            ],
            [
                'title' => 'Подписчики новых статей',
                'description' => 'Список подписчиков с доступной технической информацией.',
                'url' => route('admin.mailing_subscribers.index'),
            ],
            [
                'title' => 'Короткие ссылки',
                'description' => 'Серверный журнал переходов по ссылкам вида /me/source.',
                'url' => route('admin.personal_link_visits.index'),
            ],
            [
                'title' => 'Просмотры страниц',
                'description' => 'Собственный first-party трекинг публичных страниц сайта.',
                'url' => route('admin.site_page_visits.index'),
            ],
        ];

        return view('admin.index', compact('sections'));
    }
}
