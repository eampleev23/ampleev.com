#!/bin/bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")" && pwd)"
BLOG_DIR="$ROOT_DIR/blog"
DEFAULT_BRANCH="${2:-master}"
TEXT_URL="${1:-}"

if [ -z "$TEXT_URL" ]; then
    echo "Использование: ./publish-article-helper.sh <text_url> [branch]"
    echo "Пример: ./publish-article-helper.sh moy_novyy_post master"
    exit 1
fi

echo "== Проверка локального черновика =="

DRAFT_PATH="$BLOG_DIR/storage/drafts/$TEXT_URL.html"
if [ ! -f "$DRAFT_PATH" ]; then
    echo "Файл черновика не найден: $DRAFT_PATH"
    exit 1
fi

echo "Найден черновик: $DRAFT_PATH"
echo ""

echo "== Напоминание о локальной публикации =="
echo "Перед пушем статья должна быть локально опубликована:"
echo "cd \"$BLOG_DIR\" && ./php-docker artisan publish $TEXT_URL"
echo ""

echo "== Push в origin/$DEFAULT_BRANCH =="
"$ROOT_DIR/git-push-with-status.sh" "$DEFAULT_BRANCH"
echo ""

PROD_CMD="cd /var/www/ampleev.com/blog && php artisan publish $TEXT_URL"

if [ -n "${AMPLEEV_PROD_SSH:-}" ]; then
    echo "== Публикация на проде =="
    echo "Выполняю: ssh $AMPLEEV_PROD_SSH '$PROD_CMD'"
    ssh "$AMPLEEV_PROD_SSH" "$PROD_CMD"
    echo ""
    echo "Статья опубликована на проде."
else
    echo "== Следующий шаг =="
    echo "Выполни на проде:"
    echo "$PROD_CMD"
    echo ""
    echo "Если хочешь автоматизировать и этот шаг, задай переменную окружения:"
    echo "export AMPLEEV_PROD_SSH='<ssh-host-or-alias>'"
    echo "После этого скрипт будет сам вызывать ssh."
fi
