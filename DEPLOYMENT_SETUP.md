# Настройка автоматического деплоя через GitHub Actions

## 📋 Что нужно сделать

### 1. Настройка GitHub Secrets

Перейдите в настройки репозитория на GitHub:
- Settings → Secrets and variables → Actions → New repository secret

Добавьте следующие секреты:

#### `SSH_HOST`
- Значение: IP-адрес или домен вашего сервера (например: `ampleev.com` или IP-адрес)

#### `SSH_USERNAME`
- Значение: Имя пользователя для SSH (обычно `root`)

#### `SSH_PORT`
- Значение: Порт SSH (обычно `22`)

#### `SSH_PRIVATE_KEY`
- Значение: Приватный SSH ключ для доступа к серверу

### 2. Генерация SSH ключа (если еще нет)

Если у вас еще нет SSH ключа для сервера:

```bash
# На вашем локальном компьютере
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/github_actions_deploy

# Скопируйте публичный ключ на сервер
ssh-copy-id -i ~/.ssh/github_actions_deploy.pub root@ampleev.com

# Или вручную добавьте содержимое ~/.ssh/github_actions_deploy.pub в ~/.ssh/authorized_keys на сервере
```

**Важно:** В GitHub Secrets нужно добавить **приватный** ключ (`~/.ssh/github_actions_deploy`), а на сервер - **публичный** (`~/.ssh/github_actions_deploy.pub`).

### 3. Проверка доступа к серверу

Убедитесь, что:
- Git репозиторий на сервере настроен правильно
- Путь к проекту: `/var/www/ampleev.com/blog`
- PHP и Composer доступны в PATH
- Права на выполнение команд есть

### 4. Тестирование деплоя

После настройки секретов:
1. Сделайте коммит и push в ветку `master`
2. Перейдите в раздел "Actions" на GitHub
3. Проверьте, что workflow запустился и выполнился успешно

## 🔧 Что делает workflow

При каждом `git push origin master`:
1. Клонирует код из репозитория
2. Подключается к серверу по SSH
3. Выполняет:
   - `git pull origin master` - обновляет код
   - `php artisan config:clear` - очищает кеш конфигурации
   - `php artisan config:cache` - кеширует конфигурацию
   - `php artisan route:clear` - очищает кеш маршрутов
   - `php artisan route:cache` - кеширует маршруты
   - `php artisan view:clear` - очищает кеш представлений
   - `php artisan view:cache` - кеширует представления
   - `php artisan optimize:clear` - очищает все кеши
   - `php artisan optimize` - оптимизирует приложение

## ⚠️ Важные замечания

1. **Безопасность**: Никогда не коммитьте SSH ключи в репозиторий
2. **Миграции**: Если нужно выполнять миграции, добавьте в workflow:
   ```bash
   php artisan migrate --force
   ```
3. **Composer**: Если нужно обновлять зависимости, добавьте:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
4. **Логи**: Проверяйте логи в разделе "Actions" на GitHub при ошибках

## 🔍 Альтернативный вариант (GitHub Webhook)

Если предпочитаете использовать webhook (как для Go-сервиса):

1. Создайте скрипт на сервере: `/var/www/ampleev.com/deploy.sh`
2. Настройте webhook в GitHub: Settings → Webhooks → Add webhook
3. URL: `https://ampleev.com/webhook/deploy` (нужно создать endpoint)
4. Content type: `application/json`
5. Secret: сгенерируйте секретный ключ

Но GitHub Actions проще в настройке и не требует создания endpoint на сервере.

