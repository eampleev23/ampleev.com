# Публикация статьи

Основной код блога находится в `blog`.

## Что происходит технически

1. Локально создается HTML-черновик в `blog/storage/drafts/<text_url>.html`.
2. Preview по `/drafts/<text_url>` работает только в local-окружении и синхронизирует черновик в локальную БД как `confirmed=0`.
3. Локальная команда `php artisan publish <text_url>` публикует RU-статью в локальной БД.
4. Локальная команда `php artisan publish <text_url> --lang=en` публикует EN-перевод в локальной БД; EN publish выполняется только после успешного RU publish.
5. `git push origin master` запускает GitHub Actions деплой.
6. На проде workflow делает `php artisan drafts:sync`, но он обновляет только уже опубликованные статьи.
7. Для новой статьи после деплоя нужно отдельно выполнить production publish. Production `php artisan publish <text_url>` умеет создать новую RU-статью из deployed draft-файла, даже если записи в production DB еще нет.
8. Production `/drafts/<text_url>` и `/en/drafts/<text_url>` открывать для проверки не нужно: preview закрыт вне local и может корректно отдавать 404.

## Локальный запуск

Если Docker еще не поднят:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
docker compose up -d
```

Если Docker Desktop выключен, сначала нужно его запустить.

## Создание и проверка черновика

Создать RU-черновик:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan make:article "Заголовок статьи"
```

По умолчанию используется шаблон `basic-ru`. Если нужен явный шаблон:

```bash
./php-docker artisan make:article "Заголовок статьи" --template=basic-ru
```

Файл появится здесь:

`blog/storage/drafts/<text_url>.html`

Обязательные мета-поля:

- `article-title`
- `article-seo-description`
- `article-blog-section`
- `article-user-id`
- `article-main-image-path`
- `article-main-image-mode`
- `article-layout`
- `article-html-title`

Для статей серии должен быть:

- `article-show-feedback-questions` со значением `true`

Обязательные блоки в `<body>`:

- `<div class="first-paragraph">`
- `<div class="content">`

Локальный preview:

```text
http://localhost:8000/drafts/<text_url>
```

EN-черновик создается после RU-версии:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan make:article-en <text_url>
```

EN preview:

```text
http://localhost:8000/en/drafts/<text_url>
```

## Локальные publish/checks

Перед пушем локально проверить публикацию:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan publish <text_url>
./php-docker artisan publish <text_url> --lang=en
./php-docker artisan drafts:sync --only=<text_url> --dry-run
```

EN publish выполнять только после успешного RU publish.

## Коммит и push

После approval коммитить и пушить только файлы этой статьи и явно связанную с ней публикационную метаинформацию:

- `blog/storage/drafts/<text_url>.html`
- `blog/storage/drafts/en/<text_url>.html`
- новые/замененные изображения статьи в `blog/public/assets/img/articles`
- research brief в `blog/storage/research`
- изменения в `blog/storage/glossaries/ai_terms_ru.md`, если добавлялись термины
- изменения в `blog/storage/article_series.md`
- approved homepage redirect changes в `blog/routes/web.php`

Если есть unrelated dirty files, не добавлять их в commit. Если для публикации нужны code fixes, запросить отдельное подтверждение и лучше коммитить их отдельно.

Push:

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com
./git-push-with-status.sh master
```

или:

```bash
git push origin master
```

## Production happy path

После успешного деплоя проверить, что сервер подтянул нужный commit:

```bash
ssh simplecloud 'cd /var/www/ampleev.com/blog && git rev-parse HEAD'
```

Если используется другой SSH alias/host, команда остается той же формы.

Опубликовать RU:

```bash
ssh simplecloud 'cd /var/www/ampleev.com/blog && php artisan publish <text_url>'
```

Опубликовать EN только после успешного RU publish:

```bash
ssh simplecloud 'cd /var/www/ampleev.com/blog && php artisan publish <text_url> --lang=en'
```

Не проверять production `/drafts/<text_url>`: это local-only preview.

## Production sanity checks

После production publish проверить в БД или через доступный artisan/SQL-инструмент:

- RU article найден по `articles.text_url`;
- `confirmed=1`;
- `created_at` установлен и близок к ожидаемому времени публикации;
- `show_feedback_questions=1` для статьи серии;
- `main_image_mode=static`, если пользователь явно не просил zoom;
- ожидаемый `article_layout`;
- EN translation существует с `locale=en` и ожидаемым `text_url`.

Проверить публичные страницы:

- RU article URL открывается напрямую.
- EN article URL открывается напрямую.
- RU article показывает RU feedback questions и отправляет feedback на `/article-feedback`.
- EN article показывает EN feedback questions и отправляет feedback на `/en/article-feedback`.
- `/en/` ведет на ожидаемую EN-статью.
- `blog/routes/web.php` содержит ожидаемые homepage redirects.

Не считать redirect с `/` на EN ошибкой сам по себе: на него могут влиять geo, headers, cookies или locale preference. Для RU проверять прямой RU article URL и код маршрута.

## Registry после publication

После production publication обновить `blog/storage/article_series.md`:

- перенести статью из Draft/Planned в Published;
- добавить production RU/EN URLs;
- добавить publication date;
- актуализировать оставшиеся planned questions.

Затем сделать follow-up commit/push только с registry update, если этот файл менялся уже после production publish.

## Быстрая памятка

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
./php-docker artisan publish <text_url>
./php-docker artisan publish <text_url> --lang=en
./php-docker artisan drafts:sync --only=<text_url> --dry-run

cd /Users/eampleev/PhpstormProjects/new_ampleev.com
./git-push-with-status.sh master

ssh simplecloud 'cd /var/www/ampleev.com/blog && git rev-parse HEAD'
ssh simplecloud 'cd /var/www/ampleev.com/blog && php artisan publish <text_url>'
ssh simplecloud 'cd /var/www/ampleev.com/blog && php artisan publish <text_url> --lang=en'
```

## Риски и замечания

- Для новой статьи одного `git push origin master` недостаточно.
- `drafts:sync` в деплое не создает новую публикацию с нуля, а только синхронизирует уже опубликованные статьи.
- Production `php artisan publish <text_url>` создает новую RU-статью из draft-файла, если записи еще нет.
- EN publish требует существующую RU-статью.
- Если после preview изменить `article-title`, для новой publication URL берется из имени draft-файла, а для уже опубликованной статьи существующий `text_url` сохраняется.
- Если статья уже опубликована и меняется только HTML-файл, достаточно обычного деплоя: workflow сам вызовет `php artisan drafts:sync`.
