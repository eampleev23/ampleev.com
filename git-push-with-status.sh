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
            
            # Используем текущее время как точку отсчета для таймера
            TRACKING_START_TIME=$(date +%s)
            
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
            echo "📊 Статус деплоя:"
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
            echo "   Workflow ID: $WORKFLOW_RUN"
            echo "   Статус: $STATUS"
            
            if [ "$STATUS" == "completed" ]; then
                # Получаем реальное время начала и завершения из GitHub для точного расчета
                STARTED_AT=$(gh run view "$WORKFLOW_RUN" --json startedAt --jq '.startedAt' 2>/dev/null)
                COMPLETED_AT=$(gh run view "$WORKFLOW_RUN" --json completedAt --jq '.completedAt' 2>/dev/null)
                
                if [ -n "$STARTED_AT" ] && [ "$STARTED_AT" != "null" ] && [ -n "$COMPLETED_AT" ] && [ "$COMPLETED_AT" != "null" ]; then
                    # Конвертируем ISO 8601 в Unix timestamp (для macOS)
                    if [[ "$OSTYPE" == "darwin"* ]]; then
                        START_TIME=$(date -j -f "%Y-%m-%dT%H:%M:%SZ" "${STARTED_AT}" "+%s" 2>/dev/null || date -j -f "%Y-%m-%dT%H:%M:%S%z" "${STARTED_AT}" "+%s" 2>/dev/null || echo "")
                        END_TIME=$(date -j -f "%Y-%m-%dT%H:%M:%SZ" "${COMPLETED_AT}" "+%s" 2>/dev/null || date -j -f "%Y-%m-%dT%H:%M:%S%z" "${COMPLETED_AT}" "+%s" 2>/dev/null || echo "")
                    else
                        START_TIME=$(date -d "$STARTED_AT" "+%s" 2>/dev/null || echo "")
                        END_TIME=$(date -d "$COMPLETED_AT" "+%s" 2>/dev/null || echo "")
                    fi
                    
                    if [ -n "$END_TIME" ] && [ -n "$START_TIME" ]; then
                        DURATION=$((END_TIME - START_TIME))
                        echo "   ⏱️  Время деплоя: ${DURATION} сек"
                    fi
                fi
                
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
                
                # Периодически проверяем статус с таймером
                MAX_ATTEMPTS=120
                ATTEMPT=0
                ELAPSED=0
                
                # Выводим начальный таймер
                printf "   ⏱️  Время деплоя: %d сек" "$ELAPSED"
                
                while [ "$STATUS" != "completed" ] && [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
                    sleep 1
                    ATTEMPT=$((ATTEMPT + 1))
                    
                    # Вычисляем прошедшее время с момента начала отслеживания
                    CURRENT_TIME=$(date +%s)
                    ELAPSED=$((CURRENT_TIME - TRACKING_START_TIME))
                    
                    # Обновляем статус
                    STATUS=$(gh run view "$WORKFLOW_RUN" --json status --jq '.status' 2>/dev/null)
                    CONCLUSION=$(gh run view "$WORKFLOW_RUN" --json conclusion --jq '.conclusion // "null"' 2>/dev/null)
                    
                    # Выводим таймер в реальном времени (перезаписываем строку)
                    printf "\r   ⏱️  Время деплоя: %d сек" "$ELAPSED"
                    
                    if [ "$STATUS" == "completed" ]; then
                        # Получаем реальное время начала и завершения из GitHub для точного расчета
                        STARTED_AT=$(gh run view "$WORKFLOW_RUN" --json startedAt --jq '.startedAt' 2>/dev/null)
                        COMPLETED_AT=$(gh run view "$WORKFLOW_RUN" --json completedAt --jq '.completedAt' 2>/dev/null)
                        
                        if [ -n "$STARTED_AT" ] && [ "$STARTED_AT" != "null" ] && [ -n "$COMPLETED_AT" ] && [ "$COMPLETED_AT" != "null" ]; then
                            # Конвертируем ISO 8601 в Unix timestamp (для macOS)
                            if [[ "$OSTYPE" == "darwin"* ]]; then
                                START_TIME=$(date -j -f "%Y-%m-%dT%H:%M:%SZ" "${STARTED_AT}" "+%s" 2>/dev/null || date -j -f "%Y-%m-%dT%H:%M:%S%z" "${STARTED_AT}" "+%s" 2>/dev/null || echo "")
                                END_TIME=$(date -j -f "%Y-%m-%dT%H:%M:%SZ" "${COMPLETED_AT}" "+%s" 2>/dev/null || date -j -f "%Y-%m-%dT%H:%M:%S%z" "${COMPLETED_AT}" "+%s" 2>/dev/null || echo "")
                            else
                                START_TIME=$(date -d "$STARTED_AT" "+%s" 2>/dev/null || echo "")
                                END_TIME=$(date -d "$COMPLETED_AT" "+%s" 2>/dev/null || echo "")
                            fi
                            
                            if [ -n "$END_TIME" ] && [ -n "$START_TIME" ]; then
                                DURATION=$((END_TIME - START_TIME))
                            else
                                DURATION=$ELAPSED
                            fi
                        else
                            DURATION=$ELAPSED
                        fi
                        
                        echo ""
                        echo ""
                        if [ "$CONCLUSION" == "success" ]; then
                            echo "   ✅ Деплой успешно завершен!"
                        elif [ "$CONCLUSION" == "failure" ]; then
                            echo "   ❌ Деплой завершился с ошибкой"
                        else
                            echo "   ⚠️  Деплой завершен со статусом: $CONCLUSION"
                        fi
                        echo "   ⏱️  Общее время деплоя: ${DURATION} сек"
                        break
                    fi
                done
                
                if [ "$STATUS" != "completed" ]; then
                    echo ""
                    echo ""
                    CURRENT_TIME=$(date +%s)
                    ELAPSED=$((CURRENT_TIME - TRACKING_START_TIME))
                    echo "   ⏱️  Превышено время ожидания (${ELAPSED} сек). Проверьте статус вручную."
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

