# Публикация Новой Статьи

Основной код блога находится в `/blog`.

## Что происходит технически

1. Локально создается HTML-черновик в `blog/storage/drafts/<text_url>.html`.
2. Preview по `/drafts/<text_url>` синхронизирует черновик в локальную БД как `confirmed=0`.
3. Локальная команда `php artisan publish <text_url>` переводит статью в `confirmed=1` только в локальной БД.
4. `git push origin master` запускает GitHub Actions деплой.
5. На проде workflow делает `php artisan drafts:sync`, но он обновляет только уже опубликованные статьи.
6. Для новой статьи после деплоя нужно отдельно выполнить на проде `php artisan publish <text_url>`.

## Локальный запуск

Если Docker еще не поднят:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
docker compose up -d
```

Если Docker Desktop выключен, сначала нужно его запустить.

## Типовой workflow

### 1. Создать черновик

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan make:article "Заголовок статьи"
```

По умолчанию используется шаблон `basic-ru`.

Если нужен явный шаблон:

```bash
./php-docker artisan make:article "Заголовок статьи" --template=basic-ru
```

### 2. Отредактировать HTML-черновик

Файл появится здесь:

`blog/storage/drafts/<text_url>.html`

Обязательные мета-поля:

- `article-title`
- `article-seo-description`
- `article-blog-section`
- `article-user-id`
- `article-main-image-path`
- `article-html-title`

Обязательные блоки в `<body>`:

- `<div class="first-paragraph">`
- `<div class="content">`

### 3. Открыть preview

```text
http://localhost:8000/drafts/<text_url>
```

Важно: preview работает только в локальном окружении.

### 4. Локально опубликовать черновик

Это переводит статью в `confirmed=1` в локальной БД и позволяет дальше синхронизировать ее на проде.

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan publish <text_url>
```

### 5. Закоммитить файл черновика

Нужен как минимум файл:

`blog/storage/drafts/<text_url>.html`

Если добавлены картинки, их тоже нужно закоммитить.

### 6. Отправить в `master`

Вариант 1:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com
./git-push-with-status.sh master
```

Вариант 2:

```bash
git push origin master
```

### 7. Опубликовать статью на проде

После успешного деплоя на сервере выполнить:

```bash
cd /var/www/ampleev.com/blog
php artisan publish <text_url>
```

Если есть SSH-доступ:

```bash
ssh <prod-host> 'cd /var/www/ampleev.com/blog && php artisan publish <text_url>'
```

## Быстрая памятка

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan make:article "Заголовок статьи"

# редактируешь blog/storage/drafts/<text_url>.html

./php-docker artisan publish <text_url>

cd /Users/eampleev/PhpstormProjects/new_ampleev.com
./git-push-with-status.sh master

# после успешного деплоя:
ssh <prod-host> 'cd /var/www/ampleev.com/blog && php artisan publish <text_url>'
```

## Риски и замечания

- Для новой статьи одного `git push origin master` недостаточно.
- `drafts:sync` в деплое не создает новую публикацию с нуля, а только синхронизирует уже опубликованные статьи.
- Если после preview изменить `article-title`, `text_url` может измениться при `publish`.
- Если статья уже опубликована и меняется только HTML-файл, достаточно обычного деплоя: workflow сам вызовет `php artisan drafts:sync`.
