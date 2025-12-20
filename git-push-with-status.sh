#!/bin/bash

# Скрипт для push с отображением статуса деплоя
# Использование: ./git-push-with-status.sh [branch]
# По умолчанию: master

BRANCH=${1:-master}
REPO_OWNER="eampleev23"
REPO_NAME="ampleev.com"
ACTIONS_URL="https://github.com/$REPO_OWNER/$REPO_NAME/actions"

echo "🚀 Выполняю git push origin $BRANCH..."
echo ""

# Выполняем push
git push origin "$BRANCH"

# Проверяем результат push
if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Push выполнен успешно"
    echo ""
    echo "⏳ Ожидаю запуск GitHub Actions (5 секунд)..."
    sleep 5
    
    # Проверяем доступность GitHub CLI
    if command -v gh &> /dev/null; then
        echo "📊 Проверяю статус деплоя через GitHub CLI..."
        echo ""
        
        # Получаем последний workflow run через GitHub CLI
        WORKFLOW_RUN=$(gh run list --branch "$BRANCH" --limit 1 --json databaseId --jq '.[0].databaseId' 2>/dev/null)
        
        if [ -n "$WORKFLOW_RUN" ] && [ "$WORKFLOW_RUN" != "null" ]; then
            # Получаем статус через GitHub CLI
            STATUS=$(gh run view "$WORKFLOW_RUN" --json status --jq '.status' 2>/dev/null)
            CONCLUSION=$(gh run view "$WORKFLOW_RUN" --json conclusion --jq '.conclusion // "null"' 2>/dev/null)
            WORKFLOW_URL=$(gh run view "$WORKFLOW_RUN" --json url --jq '.url' 2>/dev/null)
            
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
                echo "🔄 Отслеживаю статус в реальном времени..."
                
                # Открываем браузер
                if command -v open &> /dev/null; then
                    open "$WORKFLOW_URL" 2>/dev/null
                fi
                
                # Периодически проверяем статус
                MAX_ATTEMPTS=30
                ATTEMPT=0
                while [ "$STATUS" != "completed" ] && [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
                    sleep 5
                    ATTEMPT=$((ATTEMPT + 1))
                    STATUS=$(gh run view "$WORKFLOW_RUN" --json status --jq '.status' 2>/dev/null)
                    CONCLUSION=$(gh run view "$WORKFLOW_RUN" --json conclusion --jq '.conclusion // "null"' 2>/dev/null)
                    
                    if [ "$STATUS" == "completed" ]; then
                        echo ""
                        if [ "$CONCLUSION" == "success" ]; then
                            echo "   ✅ Деплой успешно завершен!"
                        elif [ "$CONCLUSION" == "failure" ]; then
                            echo "   ❌ Деплой завершился с ошибкой"
                        else
                            echo "   ⚠️  Деплой завершен со статусом: $CONCLUSION"
                        fi
                        break
                    else
                        echo -n "."
                    fi
                done
                
                if [ "$STATUS" != "completed" ]; then
                    echo ""
                    echo "   ⏱️  Превышено время ожидания. Проверьте статус вручную."
                fi
            else
                echo "   ℹ️  Статус: $STATUS"
            fi
            
            echo ""
            echo "🔗 Ссылка на workflow: $WORKFLOW_URL"
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
            echo ""
        else
            echo "⚠️  Не удалось получить информацию о workflow run"
            echo "📋 Открываю страницу Actions в браузере..."
            if command -v open &> /dev/null; then
                open "$ACTIONS_URL" 2>/dev/null
            fi
            echo "🔗 Проверьте статус: $ACTIONS_URL"
        fi
    else
        # Если GitHub CLI не установлен, используем альтернативный метод
        echo "📊 GitHub CLI не установлен. Используется альтернативный метод..."
        echo ""
        
        # Пытаемся получить токен из переменной окружения
        GITHUB_TOKEN=${GITHUB_TOKEN:-""}
        
        if [ -n "$GITHUB_TOKEN" ]; then
            # Используем токен для API запроса
            WORKFLOW_RUN=$(curl -s -H "Authorization: token $GITHUB_TOKEN" "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/actions/runs?branch=$BRANCH&per_page=1" 2>/dev/null | grep -o '"id":[0-9]*' | head -1 | cut -d':' -f2)
            
            if [ -n "$WORKFLOW_RUN" ]; then
                WORKFLOW_DATA=$(curl -s -H "Authorization: token $GITHUB_TOKEN" "https://api.github.com/repos/$REPO_OWNER/$REPO_NAME/actions/runs/$WORKFLOW_RUN" 2>/dev/null)
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
                fi
                
                echo ""
                echo "🔗 Ссылка на workflow: $WORKFLOW_URL"
                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
                echo ""
            fi
        else
            # Если нет ни CLI, ни токена - открываем браузер и показываем инструкции
            echo "⚠️  Для автоматической проверки статуса нужен GitHub CLI или токен"
            echo ""
            echo "💡 Варианты решения:"
            echo "   1. Установите GitHub CLI: brew install gh"
            echo "   2. Или установите переменную окружения GITHUB_TOKEN"
            echo ""
            echo "📋 Открываю страницу Actions в браузере..."
            if command -v open &> /dev/null; then
                open "$ACTIONS_URL" 2>/dev/null
            fi
            echo "🔗 Проверьте статус: $ACTIONS_URL"
            echo ""
        fi
    fi
else
    echo ""
    echo "❌ Push завершился с ошибкой"
    exit 1
fi

