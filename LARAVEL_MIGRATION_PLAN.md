# План миграции Laravel 7 → 12

## 📊 Анализ текущего проекта

### Обнаруженные проблемы производительности:

1. **N+1 Query проблемы:**
   - `BlogController::show()` - загружает статьи без `with('user', 'blog_section')`
   - `Comment::getAllCommentsHtml()` - загружает комментарии без eager loading
   - Отсутствие `withCount()` для счетчиков комментариев

2. **Неоптимальные запросы:**
   - `Article::getRandomArticles()` - загружает 100 статей в память, затем выбирает случайные
   - `Article::get_comments_counter()` - отдельный запрос вместо `withCount()`
   - Множественные запросы в одном контроллере (4 запроса в `show()`)

3. **Устаревшие паттерны:**
   - Строковые отношения (`'App\User'`) вместо классов
   - Устаревший `use Request;` вместо фасада
   - `RouteServiceProvider` с `$namespace`

---

## 🎯 Ожидаемые улучшения после миграции

### Для пользователей (видимые метрики):

| Метрика | Текущее | После обновления | Улучшение |
|---------|---------|------------------|-----------|
| **Время загрузки страницы блога** | ~800-1200ms | ~400-600ms | **40-50% быстрее** |
| **Время загрузки статьи** | ~600-900ms | ~300-450ms | **50% быстрее** |
| **Количество SQL запросов на страницу** | 15-25 | 3-5 | **80% меньше** |
| **Использование памяти** | ~25-35 MB | ~15-20 MB | **40% меньше** |
| **TTFB (Time To First Byte)** | ~200-300ms | ~100-150ms | **50% быстрее** |

### Для разработчика (технические метрики):

| Метрика | Текущее | После обновления | Улучшение |
|---------|---------|------------------|-----------|
| **Безопасность** | ❌ Нет обновлений | ✅ Регулярные патчи | **Критично** |
| **Поддержка PHP** | PHP 7.2-7.4 | PHP 8.2+ | **Производительность +30%** |
| **Скорость компиляции** | Медленная | Быстрая (OPcache улучшен) | **2-3x быстрее** |
| **Размер vendor/** | ~150 MB | ~120 MB | **20% меньше** |

---

## 📋 Пошаговый план миграции

### Этап 0: Подготовка (30 минут)

**Создайте бэкап:**
```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
git checkout -b laravel-migration
git add .
git commit -m "Backup before Laravel migration"
```

**Проверьте текущее состояние:**
```bash
# Убедитесь что Docker контейнеры запущены
docker-compose ps

# Проверьте текущую версию
docker-compose exec app php artisan --version
```

---

### Этап 1: Исправление кода перед миграцией (1-2 часа)

#### 1.1. Исправление использования Request

**Файл:** `blog/app/Article.php`

**Было:**
```php
use Request;
...
$thisIp = Request::ip();
```

**Стало:**
```php
use Illuminate\Support\Facades\Request;
...
$thisIp = Request::ip();
```

#### 1.2. Замена строковых отношений на классы

**Файлы:** `blog/app/Article.php`, `blog/app/Comment.php`

**Было:**
```php
public function user()
{
    return $this->belongsTo('App\User');
}
```

**Стало:**
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

#### 1.3. Обновление зависимостей в composer.json

**Файл:** `blog/composer.json`

Замените:
```json
"fideloper/proxy": "^4.2",
"facade/ignition": "^2.0",
"fzaninotto/faker": "^1.9.1",
```

На:
```json
"fruitcake/laravel-trusted-proxy": "^1.0",
"spatie/laravel-ignition": "^1.0",
"fakerphp/faker": "^1.23",
```

---

### Этап 2: Миграция Laravel 7 → 8 (2-3 часа)

#### 2.1. Обновление composer.json

```json
"require": {
    "php": "^7.3|^8.0",
    "laravel/framework": "^8.0",
    "laravel/socialite": "^5.0",
    "laravel/tinker": "^2.5"
},
"require-dev": {
    "barryvdh/laravel-debugbar": "^3.6",
    "spatie/laravel-ignition": "^1.0",
    "phpunit/phpunit": "^9.3"
}
```

#### 2.2. Обновление RouteServiceProvider

**Файл:** `blog/app/Providers/RouteServiceProvider.php`

Удалите свойство `$namespace` и обновите методы:

```php
protected function mapWebRoutes()
{
    Route::middleware('web')
         ->group(base_path('routes/web.php'));
}

protected function mapApiRoutes()
{
    Route::prefix('api')
         ->middleware('api')
         ->group(base_path('routes/api.php'));
}
```

#### 2.3. Обновление routes/web.php

Добавьте `use` в начало файла:
```php
use App\Http\Controllers\BlogController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\AuthenticatedSessionController;
```

И обновите роуты:
```php
// Было:
Route::get('/', 'StaticController@about_me')->name('home');

// Стало:
Route::get('/', [StaticController::class, 'about_me'])->name('home');
```

#### 2.4. Обновление TrustProxies middleware

**Файл:** `blog/app/Http/Middleware/TrustProxies.php`

Замените:
```php
use Fideloper\Proxy\TrustProxies as Middleware;
```

На:
```php
use Illuminate\Http\Middleware\TrustProxies as Middleware;
```

#### 2.5. Обновление Kernel.php

**Файл:** `blog/app/Http/Kernel.php`

Замените:
```php
\App\Http\Middleware\CheckForMaintenanceMode::class,
```

На:
```php
\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
```

#### 2.6. Выполнение обновления

```bash
# Обновление зависимостей
docker-compose exec app composer update

# Очистка кеша
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan route:clear
```

---

### Этап 3: Миграция Laravel 8 → 9 (1-2 часа)

#### 3.1. Обновление composer.json

```json
"require": {
    "php": "^8.0",
    "laravel/framework": "^9.0"
}
```

#### 3.2. Обновление Ignition

```json
"require-dev": {
    "spatie/laravel-ignition": "^1.0"
}
```

#### 3.3. Выполнение обновления

```bash
docker-compose exec app composer update
docker-compose exec app php artisan optimize:clear
```

---

### Этап 4: Миграция Laravel 9 → 10 (1-2 часа)

#### 4.1. Обновление composer.json

```json
"require": {
    "php": "^8.1",
    "laravel/framework": "^10.0"
}
```

#### 4.2. Обновление методов моделей

Laravel 10 требует обновления некоторых методов. Проверьте все модели.

#### 4.3. Выполнение обновления

```bash
docker-compose exec app composer update
docker-compose exec app php artisan optimize:clear
```

---

### Этап 5: Миграция Laravel 10 → 11 (2-3 часа)

#### 5.1. Обновление composer.json

```json
"require": {
    "php": "^8.2",
    "laravel/framework": "^11.0"
}
```

#### 5.2. Упрощение структуры (опционально)

Laravel 11 упрощает структуру. Можно удалить некоторые файлы конфигурации.

#### 5.3. Обновление bootstrap/app.php

Laravel 11 использует новый способ структурирования приложения.

#### 5.4. Выполнение обновления

```bash
docker-compose exec app composer update
docker-compose exec app php artisan optimize:clear
```

---

### Этап 6: Миграция Laravel 11 → 12 (1-2 часа)

#### 6.1. Обновление composer.json

```json
"require": {
    "php": "^8.2",
    "laravel/framework": "^12.0"
}
```

#### 6.2. Выполнение обновления

```bash
docker-compose exec app composer update
docker-compose exec app php artisan optimize:clear
```

---

## 🚀 Оптимизации после миграции

### 1. Исправление N+1 проблем

**Файл:** `blog/app/Http/Controllers/BlogController.php`

```php
public function show()
{
    $articles = Article::with(['user', 'blog_section'])
        ->orderBy('created_at', 'desc')
        ->where('type_article', '=', 'article')
        ->where('confirmed', '=', '1')
        ->get();
    
    // ... остальной код
}
```

### 2. Оптимизация getRandomArticles

**Файл:** `blog/app/Article.php`

```php
public static function getRandomArticles($quantity = 2, $article_id)
{
    return Article::where('confirmed', '=', '1')
        ->where('type_article', '=', 'article')
        ->where('id', '!=', $article_id)
        ->inRandomOrder()
        ->limit($quantity)
        ->get();
}
```

### 3. Использование withCount

**Файл:** `blog/app/Article.php`

```php
// Вместо отдельного метода get_comments_counter()
// Используйте в запросах:
Article::withCount('comments')->get();
```

---

## ✅ Чеклист проверки после миграции

- [ ] Все страницы открываются без ошибок
- [ ] Блог отображается корректно
- [ ] Статьи открываются
- [ ] Комментарии работают
- [ ] Форма подписки работает
- [ ] Авторизация работает
- [ ] Нет ошибок в логах
- [ ] Производительность улучшилась (проверить через DevTools)

---

## 📈 Метрики для измерения успеха

### До миграции (зафиксируйте):

1. **Время загрузки страницы блога:**
   ```bash
   # Используйте Chrome DevTools Network tab
   # Или curl:
   curl -w "@curl-format.txt" -o /dev/null -s https://ampleev.com/blog
   ```

2. **Количество SQL запросов:**
   - Включите Debugbar
   - Откройте страницу блога
   - Запишите количество запросов

3. **Использование памяти:**
   ```php
   // Добавьте в контроллер временно:
   dd(memory_get_usage(true) / 1024 / 1024); // MB
   ```

### После миграции:

Повторите те же измерения и сравните результаты.

---

## ⚠️ Возможные проблемы и решения

### Проблема: Ошибки при обновлении зависимостей

**Решение:**
```bash
docker-compose exec app composer update --with-all-dependencies
```

### Проблема: Конфликты версий пакетов

**Решение:**
Проверьте совместимость каждого пакета с новой версией Laravel на packagist.org

### Проблема: Ошибки в роутах

**Решение:**
Убедитесь что все роуты используют синтаксис `[Controller::class, 'method']`

---

## 📝 Примечания

- Все команды выполняются через Docker: `docker-compose exec app <command>`
- Делайте коммиты после каждого успешного этапа
- Тестируйте после каждого обновления версии
- При проблемах можно откатиться через `git checkout`

---

## 🎉 После успешной миграции

1. Обновите `.cursorcontext` с новой версией Laravel
2. Удалите устаревшие зависимости
3. Обновите документацию проекта
4. Наслаждайтесь улучшенной производительностью! 🚀


