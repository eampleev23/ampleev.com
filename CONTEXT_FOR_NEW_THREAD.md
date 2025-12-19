# Контекст проекта Ampleev.com для нового треда

## 📋 Текущая ситуация

**Проект**: Персональный блог/портфолио на Laravel  
**URL**: https://ampleev.com  
**Статус**: После пуша изменений на сервер возникла ошибка 500

## 🚀 Версии

### Локальная разработка:
- **Laravel**: 12.43.1
- **PHP**: 8.2 (через Docker)
- **Docker**: PHP 8.2-fpm, MySQL 8.0, Nginx

### Продакшн (Simplecloud VPS):
- **Laravel**: 12.43.1 (мигрировано с Laravel 7)
- **PHP**: 8.2.29 (CLI и Web) - требуется подтверждение
- **Путь**: `/var/www/ampleev.com/blog`
- **Деплой**: `git pull origin master`

## ⚠️ Текущая проблема

После пуша изменений на сервер возникла ошибка 500. Логи показывают:

```
[2025-12-18 21:09:35] laravel.EMERGENCY: Unable to create configured logger. Using emergency logger. 
{"exception":"[object] (Error(code: 0): Class \"Illuminate\\Support\\Collection\" not found at /var/www/ampleev.com/blog/vendor/laravel/framework/src/Illuminate/Support/helpers.php:110)

[2025-12-18 21:09:35] laravel.ERROR: During inheritance of ArrayAccess: Uncaught ErrorException: 
Return type of Illuminate\Support\Collection::offsetExists($key) should either be compatible with ArrayAccess::offsetExists(mixed $offset): bool
```

**Возможные причины:**
1. Несовместимость версии PHP (требуется PHP 8.2+)
2. Не обновлена директория `vendor/` после миграции Laravel 7 → 12
3. Конфликт версий пакетов в `composer.json`

## 📁 Структура проекта

```
blog/
├── app/
│   ├── Http/Controllers/
│   │   ├── BlogController.php      # Блог и статьи (оптимизированы N+1 запросы)
│   │   ├── StaticController.php    # Статические страницы (about_me, cv, about_company)
│   │   └── IndexController.php      # Главная страница
│   ├── Article.php                  # Модель статей (оптимизирован getRandomArticles)
│   ├── Comment.php                  # Модель комментариев (оптимизирован getAllCommentsHtml)
│   └── ...
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php            # Основной layout с футером
│   │   └── navbar_white.blade.php   # Белое меню
│   ├── static_pages/
│   │   ├── about_me.blade.php       # Страница "Обо мне" с таймлайном "Карьера"
│   │   ├── about_company.blade.php  # Страница "О компании" (копия шаблона)
│   │   └── cv.blade.php
│   └── blog/
├── public/
│   └── assets/css/
│       └── custom.css               # Кастомные стили (таймлайн, логотипы, футер)
├── routes/
│   └── web.php                      # Роуты (обновлены под Laravel 12 синтаксис)
└── composer.json                    # PHP ^8.2, Laravel ^12.0
```

## 🔧 Недавние изменения

### 1. Миграция Laravel 7 → 12
- ✅ Обновлен `composer.json` (PHP ^8.2, Laravel ^12.0)
- ✅ Обновлены роуты в `web.php` (новый синтаксис `[Controller::class, 'method']`)
- ✅ Исправлены N+1 запросы в контроллерах (добавлен `with()`, `withCount()`)
- ✅ Оптимизированы методы моделей (`getRandomArticles`, `getAllCommentsHtml`)

### 2. Оптимизация производительности
- ✅ Добавлен eager loading в `BlogController`, `StaticController`, `IndexController`
- ✅ Заменен `get_comments_counter()` на `withCount('comments')`
- ✅ Оптимизирован `Article::getRandomArticles()` (использует `inRandomOrder()`)
- ✅ Оптимизирован `Comment::getAllCommentsHtml()` (eager loading `user`)

### 3. Frontend изменения
- ✅ Создана страница `about_company.blade.php` (копия шаблона Leap Bootstrap)
- ✅ Обновлена страница `about_me.blade.php`:
  - Добавлены AOS анимации для таймлайна
  - Изменен фон секции на белый
  - Унифицированы размеры логотипов через `custom.css`
  - Настроены отступы линий таймлайна
- ✅ Обновлен футер (белый фон, типографика)
- ✅ Добавлены стили в `custom.css` для таймлайна

### 4. Git workflow
- ✅ Ветка `laravel-migration` вмержена в `master`
- ✅ Старая ветка `laravel-migration` удалена
- ✅ Production сервер обновлен до `master`

## 🎨 Frontend технологии

- **Bootstrap 4** (планируется обновление до 5)
- **jQuery** (планируется миграция на React)
- **AOS** (Animate On Scroll) - для анимаций при скролле
- **Jarallax** - для параллакс эффектов
- **Custom CSS** - в `public/assets/css/custom.css`

## 📝 Важные файлы

### Контроллеры:
- `app/Http/Controllers/StaticController.php` - метод `about_me()` передает `$last_articles`
- `app/Http/Controllers/BlogController.php` - основной контроллер блога
- `app/Http/Controllers/IndexController.php` - главная страница

### Views:
- `resources/views/layouts/app.blade.php` - использует `$last_articles[0]->isMobile()` в футере (строка 98)
- `resources/views/static_pages/about_me.blade.php` - использует `filemtime()` для версионирования CSS

### Модели:
- `app/Article.php` - метод `isMobile()` использует `Jenssegers\Agent\Agent`
- `app/Comment.php` - рекурсивный метод `getAllCommentsHtml()`

## 🔍 Что нужно проверить на сервере

1. **Версия PHP:**
   ```bash
   php -v  # Должна быть 8.2.x
   ```

2. **Composer зависимости:**
   ```bash
   cd /var/www/ampleev.com/blog
   composer install --no-dev --optimize-autoloader
   ```

3. **Права доступа:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

4. **Кеш Laravel:**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 📚 Документация проекта

- `PROJECT_CONTEXT.md` - общий контекст проекта
- `LARAVEL_MIGRATION_PLAN.md` - план миграции Laravel 7 → 12
- `OPTIMIZATION_SUMMARY.md` - сводка оптимизаций производительности
- `GIT_WORKFLOW_GUIDE.md` - инструкции по Git workflow
- `REACT_LARAVEL_GUIDE.md` - руководство по интеграции React
- `CAREER_TIMELINE_CONTENT_BACKUP.md` - бэкап контента таймлайна

## 🎯 Текущая задача

**Исправить ошибку 500 на production сервере после пуша изменений.**

Основная проблема: `Class "Illuminate\Support\Collection" not found` - указывает на проблему с зависимостями или версией PHP.

