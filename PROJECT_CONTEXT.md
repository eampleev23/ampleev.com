# Контекст проекта Ampleev.com

## 📋 Обзор проекта

**Ampleev.com** - персональный блог/сайт-портфолио на Laravel.

## 🚀 Текущие версии

### Локальная разработка:
- **Laravel**: 12.43.1
- **PHP**: 8.2 (через Docker)
- **Docker**: PHP 8.2-fpm, MySQL 8.0, Nginx

### Продакшн (Simplecloud VPS):
- **Laravel**: 12.43.1
- **PHP**: 8.2.29 (CLI и Web)
- **Веб-сервер**: Nginx
- **База данных**: MySQL

## 📁 Структура проекта

```
blog/
├── app/
│   ├── Http/Controllers/     # Контроллеры
│   ├── Article.php            # Модель статей
│   ├── Comment.php            # Модель комментариев
│   └── ...
├── resources/views/
│   ├── layouts/               # Основные layout'ы
│   ├── blog/                  # Шаблоны блога
│   ├── static_pages/          # Статические страницы
│   └── ...
├── public/
│   ├── assets/css/            # CSS файлы
│   ├── assets/js/             # JavaScript
│   └── ...
└── routes/
    └── web.php                # Веб-роуты
```

## 🎨 Frontend

- **Bootstrap 4**
- **jQuery**
- **AOS** (Animate On Scroll)
- **Jarallax** (параллакс эффекты)
- Кастомные стили в `public/assets/css/custom.css`

## 🔧 Основные компоненты

### Контроллеры:
- `BlogController` - управление блогом и статьями
- `StaticController` - статические страницы (Обо мне, CV)
- `TestController` - тестовые страницы
- `DocsController` - документация

### Модели:
- `Article` - статьи блога
- `Comment` - комментарии к статьям
- `User` - пользователи
- `BlogSection` - разделы блога
- `ViewArticle` - просмотры статей

### Роуты:
- `/` - главная страница (Обо мне)
- `/blog` - список статей
- `/article_{text_url}` - просмотр статьи
- `/blog_section_{name}` - статьи по разделам

## 📝 Недавние изменения

### ✅ Завершена миграция Laravel 7 → 12:
- Обновлен PHP с 7.4 до 8.2
- Обновлен Laravel с 7.28.4 до 12.43.1
- Обновлены все зависимости
- Исправлены проблемы совместимости:
  - Обновлен `Request` facade
  - Заменены строковые отношения на классы
  - Исправлен порядок параметров в `Article::getRandomArticles()`
  - Исправлена проверка пустого массива в `app.blade.php`
- Оптимизирован для продакшна

## 🐳 Docker (локальная разработка)

```bash
# Запуск контейнеров
docker-compose up -d

# Выполнение команд
docker-compose exec app php artisan ...
docker-compose exec app composer ...

# Остановка
docker-compose down
```

## 🌐 Продакшн

- **Хостинг**: Simplecloud (VPS)
- **Путь**: `/var/www/ampleev.com/blog`
- **Деплой**: `git pull origin master` (или `laravel-migration`)
- **PHP-FPM**: `/run/php/php8.2-fpm.sock`
- **Nginx конфиг**: `/etc/nginx/sites-available/ampleev.com`

## ⚙️ Важные настройки

### База данных (.env):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1 (локально: db)
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root (локально: root)
DB_PASSWORD=***
```

### Особенности:
- Используется `Auth::routes()` (требует `laravel/ui`)
- Комментарии с вложенностью (рекурсивная структура)
- Подписка на рассылку
- Интеграция с AWS SES для отправки email
- Социальная авторизация (Yandex)

## 🔍 Известные особенности кода

1. **Article::getRandomArticles($article_id, $quantity = 2)** - получение случайных статей
2. **Comment::getAllCommentsHtml()** - рекурсивная генерация HTML комментариев
3. Используется `with('user')` для eager loading в комментариях
4. Есть оптимизации для производительности (но можно улучшить)

## 📚 Документация

- `LARAVEL_MIGRATION_PLAN.md` - план миграции (исторический)
- `MIGRATION_METRICS.md` - метрики улучшений
- `PRODUCTION_MIGRATION_GUIDE.md` - инструкция по обновлению на проде

## ⚠️ Важно

- **Все команды через терминал выполняются пользователем**
- AI работает только с файлами (чтение, редактирование)
- Для выполнения команд нужно просить пользователя

## 🎯 Текущий статус

✅ **Миграция завершена** - проект работает на Laravel 12.43.1 и PHP 8.2
✅ **Продакшн обновлен** - сайт работает на новой версии
✅ **Все функции работают** - блог, статьи, комментарии, подписка

---

*Последнее обновление: Декабрь 2025*

