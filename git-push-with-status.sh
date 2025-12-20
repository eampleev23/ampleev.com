#!/bin/bash

# Скрипт для push с отображением статуса деплоя
# Использование: ./git-push-with-status.sh [branch]
# По умолчанию: master

BRANCH=${1:-master}
REPO_OWNER="eampleev23"
REPO_NAME="ampleev.com"

echo "🚀 Выполняю git push origin $BRANCH..."
echo ""

# Выполняем push
git push origin "$BRANCH"

# Проверяем результат push
if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Push выполнен успешно"
    echo ""
    echo "⏳ Ожидаю запуск GitHub Actions (3 секунды)..."
    sleep 3
    
    # Получаем последний workflow run
    echo "📊 Проверяю статус деплоя..."
    echo ""
    
    # Получаем последний workflow run через GitHub API
    WORKFLOW_RUN=$(curl -s "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/actions/runs?branch=$BRANCH&per_page=1" 2>/dev/null | grep -o '"id":[0-9]*' | head -1 | cut -d':' -f2)
    
    if [ -z "$WORKFLOW_RUN" ]; then
        echo "⚠️  Не удалось получить информацию о workflow run"
        echo "📋 Проверьте статус вручную: https://github.com/$REPO_OWNER/$REPO_NAME/actions"
        exit 0
    fi
    
    # Получаем статус workflow run
    WORKFLOW_DATA=$(curl -s "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/actions/runs/$WORKFLOW_RUN" 2>/dev/null)
    STATUS=$(echo "$WORKFLOW_DATA" | grep -o '"status":"[^"]*"' | head -1 | cut -d'"' -f4)
    CONCLUSION=$(echo "$WORKFLOW_DATA" | grep -o '"conclusion":"[^"]*"' | head -1 | cut -d'"' -f4)
    
    WORKFLOW_URL="https://github.com/$REPO_OWNER/$REPO_NAME/actions/runs/$WORKFLOW_RUN"
    
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "📊 Статус деплоя:"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "   Workflow ID: $WORKFLOW_RUN"
    echo "   Статус: $STATUS"
    
    if [ "$STATUS" == "completed" ]; then
        if [ "$CONCLUSION" == "success" ]; then
            echo "   ✅ Деплой успешно завершен!"
        elif [ "$CONCLUSION" == "failure" ]; then
            echo "   ❌ Деплой завершился с ошибкой"
        else
            echo "   ⚠️  Деплой завершен со статусом: $CONCLUSION"
        fi
    elif [ "$STATUS" == "in_progress" ] || [ "$STATUS" == "queued" ]; then
        echo "   ⏳ Деплой в процессе..."
        echo ""
        echo "💡 Для отслеживания статуса в реальном времени:"
        echo "   open $WORKFLOW_URL"
    else
        echo "   ℹ️  Статус: $STATUS"
    fi
    
    echo ""
    echo "🔗 Ссылка на workflow: $WORKFLOW_URL"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo ""
else
    echo ""
    echo "❌ Push завершился с ошибкой"
    exit 1
fi

