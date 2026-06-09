# CLAUDE.md — ampleev.com

## Структура репозитория
- Laravel-приложение живёт в подкаталоге **`blog/`** (не в корне репозитория).
  - Шаблоны: `blog/resources/views/`
  - Публичные ассеты: `blog/public/assets/`
- В корне репозитория — рабочие заметки, контент-материалы и конфигурация деплоя.

## Деплой (ВАЖНО — по умолчанию использовать этот механизм)
Деплой автоматический через GitHub Actions: **любой push в ветку `master` раскатывается на прод.**

- Workflow: `.github/workflows/deploy.yml`
- Триггер: `push` в `master`.
- Что делает сервер (по SSH, `appleboy/ssh-action`):
  1. `cd /var/www/ampleev.com/blog`
  2. `git fetch origin master` + `git reset --hard origin/master` (локальные правки на сервере затираются)
  3. `php artisan migrate --force` — только если есть pending-миграции
  4. `php artisan drafts:sync`
  5. Чистка и пересборка кэшей: `config:clear/cache`, `route:clear/cache`, `view:clear/cache`, `optimize:clear`, `optimize`

**Как вносить правки по умолчанию:**
1. Внести изменения в `blog/...`.
2. Закоммитить **только относящиеся к задаче файлы** (не подметать чужие незакоммиченные изменения и временные артефакты).
3. `git push origin master` — деплой запустится сам.

Примечания:
- Blade-шаблоны пересобираются на сервере (`view:cache`), отдельных сборок фронта в workflow нет.
- Сервер делает `git reset --hard` — нельзя полагаться на ручные правки прямо на проде, всё идёт через `master`.
- Проверить статус деплоя: `gh run list --workflow=deploy.yml` / `gh run watch`.

## Частые грабли
- **Пути к ассетам в шаблонах** используй через `{{ asset('assets/...') }}` (абсолютный путь от корня). Относительные пути вида `src="assets/..."` ломаются на URL с языковым префиксом (`/en/...`, `/ru/...`) → резолвятся в `/en/assets/...` → 404.
