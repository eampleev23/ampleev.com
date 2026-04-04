<?php

namespace App\Support;

use App\Article;
use Illuminate\Http\Request;

class SiteLocale
{
    public const RU = 'ru';
    public const EN = 'en';
    public const COOKIE_NAME = 'site_locale';

    public static function normalize(?string $locale): string
    {
        $locale = is_string($locale) ? strtolower(trim($locale)) : null;

        return in_array($locale, [self::RU, self::EN], true) ? $locale : self::RU;
    }

    public static function detectFromGeo(?string $countryCode): string
    {
        return strtoupper((string) $countryCode) === 'RU' ? self::RU : self::EN;
    }

    public static function resolve(Request $request, ?string $countryCode = null): string
    {
        $routeName = $request->route()?->getName();
        if (is_string($routeName) && $routeName !== '') {
            return str_starts_with($routeName, 'en.') ? self::EN : self::RU;
        }

        $path = trim($request->path(), '/');
        if ($path === 'en' || str_starts_with($path, 'en/')) {
            return self::EN;
        }

        $cookieLocale = $request->cookie(self::COOKIE_NAME);
        if ($cookieLocale) {
            return self::normalize($cookieLocale);
        }

        return self::detectFromGeo($countryCode);
    }

    public static function preferred(Request $request, ?string $countryCode = null): string
    {
        $cookieLocale = $request->cookie(self::COOKIE_NAME);
        if ($cookieLocale) {
            return self::normalize($cookieLocale);
        }

        return self::detectFromGeo($countryCode);
    }

    public static function routeNameForLocale(string $baseName, string $locale): string
    {
        return $locale === self::EN ? 'en.' . $baseName : $baseName;
    }

    public static function switchUrl(Request $request, string $targetLocale): string
    {
        $targetLocale = self::normalize($targetLocale);
        $route = $request->route();
        $routeName = $route?->getName();

        if (!$routeName) {
            return $targetLocale === self::EN ? '/en' : '/';
        }

        $baseName = str_starts_with($routeName, 'en.') ? substr($routeName, 3) : $routeName;
        $targetRouteName = self::routeNameForLocale($baseName, $targetLocale);
        $parameters = $route->parameters();
        unset($parameters['site_locale']);

        if ($baseName === 'blog.show_article') {
            $currentArticleSlug = $parameters['article_text_url'] ?? null;

            if (is_string($currentArticleSlug) && $currentArticleSlug !== '') {
                $article = Article::with('translations')
                    ->where('text_url', $currentArticleSlug)
                    ->orWhereHas('translations', function ($query) use ($currentArticleSlug) {
                        $query->where('text_url', $currentArticleSlug);
                    })
                    ->first();

                if ($article) {
                    $parameters['article_text_url'] = $article->getRouteTextUrl($targetLocale);
                }
            }
        }

        try {
            return route($targetRouteName, $parameters);
        } catch (\Throwable $e) {
            return $targetLocale === self::EN ? '/en' : '/';
        }
    }

    public static function labels(string $locale): array
    {
        $isEn = self::normalize($locale) === self::EN;

        return [
            'site_title_suffix' => $isEn ? 'Yevgeniy Ampleev' : 'Амплеев Евгений',
            'blog' => $isEn ? 'Blog' : 'Блог',
            'contacts' => $isEn ? 'Contact' : 'Контакты',
            'terms' => $isEn ? 'Terms' : 'Правила',
            'about_me' => $isEn ? 'About Me' : 'Обо мне',
            'my_profile' => $isEn ? 'My profile' : 'Мой профиль',
            'logout' => $isEn ? 'Log out' : 'Выйти',
            'profile_description' => $isEn ? 'User profile' : 'Профиль пользователя',
            'profile_personal_info' => $isEn ? 'Personal information' : 'Личная информация',
            'profile_settings' => $isEn ? 'Settings' : 'Настройки',
            'profile_name' => $isEn ? 'Name' : 'Имя',
            'profile_email' => 'Email',
            'profile_registered_at' => $isEn ? 'Registration date' : 'Дата регистрации',
            'profile_not_specified' => $isEn ? 'Not specified' : 'Не указано',
            'profile_comment_notifications' => $isEn ? 'Comment notifications' : 'Уведомления о комментариях',
            'profile_enabled' => $isEn ? 'Enabled' : 'Включены',
            'profile_disabled' => $isEn ? 'Disabled' : 'Отключены',
            'reading_now' => $isEn ? 'Reading:' : 'Читаете:',
            'share' => $isEn ? 'Share:' : 'Поделиться:',
            'share_article' => $isEn ? 'Share this article:' : 'Поделиться этой статьей:',
            'author_article' => $isEn ? 'Article author:' : 'Автор статьи:',
            'unique_views' => $isEn ? 'Unique views' : 'Количество уникальных просмотров',
            'comments_add' => $isEn ? 'Add a comment' : 'Добавить комментарий',
            'comments_total' => $isEn ? 'Total comments:' : 'Всего комментариев:',
            'comment_placeholder_auth' => $isEn ? 'You are signed in and can write a comment' : 'Вы авторизованы и можете написать комментарий',
            'comment_placeholder_guest' => $isEn ? 'Your comment' : 'Ваш комментарий',
            'comment_notify_replies' => $isEn ? 'Notify me when someone replies' : 'Оповестить меня когда кто-то ответит',
            'comment_submit' => $isEn ? 'Send' : 'Отправить',
            'comment_reply_placeholder' => $isEn ? 'Write what you would like to reply..' : 'Напишите что бы вы хотели ответить..',
            'comment_reply' => $isEn ? 'Reply' : 'Ответить',
            'comment_counter' => $isEn ? ':count / 5000 characters (minimum 3)' : ':count / 5000 символов (минимум 3)',
            'comment_too_short' => $isEn ? 'A comment must contain at least 3 characters' : 'Комментарий должен содержать минимум 3 символа',
            'comment_too_long' => $isEn ? 'A comment cannot be longer than 5000 characters' : 'Комментарий не может быть длиннее 5000 символов',
            'auth_title' => $isEn ? 'Sign in' : 'Авторизация',
            'auth_required_comment' => $isEn ? 'You need to sign in to add a comment' : 'Для добавления комментария необходимо авторизоваться',
            'sign_in_with_yandex' => $isEn ? 'Continue with Yandex' : 'Войти через yandex',
            'auth_terms_notice' => $isEn
                ? 'By signing up or logging in, you automatically agree to them.'
                : 'Регистрируясь или авторизуясь, вы автоматически соглашаетесь с ними.',
            'comment_added_success' => $isEn ? 'Comment added successfully.' : 'Комментарий успешно добавлен!',
            'comment_save_failed' => $isEn ? 'Could not save the comment. Please try again.' : 'Не удалось сохранить комментарий. Попробуйте еще раз.',
            'comment_save_error' => $isEn ? 'An error occurred while saving the comment:' : 'Произошла ошибка при сохранении комментария:',
            'unsubscribe_invalid_link' => $isEn ? 'Invalid unsubscribe link.' : 'Неверная ссылка для отписки.',
            'unsubscribe_user_not_found' => $isEn ? 'User not found.' : 'Пользователь не найден.',
            'subscription_not_found' => $isEn ? 'Subscription not found.' : 'Подписка не найдена.',
            'related_stories' => $isEn ? 'You may also like' : 'Возможно, вам будет интересно',
            'popular_in_blog' => $isEn ? 'Popular in the blog' : 'Популярное в блоге',
            'links' => $isEn ? 'Links' : 'Ссылки',
            'quotes' => $isEn ? 'Quotes' : 'Цитаты',
            'subscribe' => $isEn ? 'Subscribe' : 'Подписаться',
            'subscribe_placeholder' => 'Email',
            'subscribe_success' => $isEn
                ? 'Thanks for your interest. We sent you a confirmation link by email. It is valid for 24 hours.'
                : 'Спасибо за ваш интерес, мы отправили вам на почту ссылку для подтверждения. Она актуальна в течение 24 часов.',
            'subscribe_error' => $isEn
                ? 'Please use a valid email.'
                : 'Пожалуйста, используйте валидный email.',
            'privacy_notice' => $isEn
                ? 'We will never share your data. See our'
                : 'Мы никогда не раскроем ваши данные. Смотрите наши',
            'and' => $isEn ? 'and' : 'и',
            'terms_link' => $isEn ? 'Terms of Use' : 'Пользовательское соглашение',
            'privacy_link' => $isEn ? 'Privacy Policy' : 'Политику Конфиденциальности',
            'copyright' => $isEn
                ? '©2010-2026 All rights reserved. Ampleev.com®'
                : '©2010-2026 Все права сохранены. Ampleev.com®',
        ];
    }
}
