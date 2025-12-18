# Руководство по Git Workflow для мержа laravel-migration → master

## 📋 Текущая ситуация

- **Ветка `laravel-migration`:** Содержит обновленный код (Laravel 12, оптимизации)
- **Ветка `master`:** Содержит старый код (Laravel 7)
- **Цель:** Сделать `laravel-migration` новой основной веткой

## ✅ Рекомендуемый подход: Переименование ветки

Это самый безопасный способ, если вы уверены, что `laravel-migration` работает корректно.

### Шаг 1: Создать резервную копию master

```bash
cd /Users/eampleev/PhpstormProjects/new_ampleev.com/blog
git checkout master
git branch master-backup-$(date +%Y%m%d)
```

### Шаг 2: Переименовать laravel-migration в master

```bash
# Переключиться на laravel-migration
git checkout laravel-migration

# Переименовать локальную ветку master в old-master
git branch -m master old-master

# Переименовать laravel-migration в master
git branch -m laravel-migration master
```

### Шаг 3: Обновить удаленный репозиторий

```bash
# Удалить старый master на удаленном сервере
git push origin --delete master

# Отправить новую ветку master
git push origin master

# Установить upstream для новой master
git push --set-upstream origin master
```

### Шаг 4: Очистка (опционально)

```bash
# Удалить локальную резервную копию (если все работает)
git branch -D old-master

# Или оставить для безопасности
```

## 🔄 Альтернативный подход: Merge (если нужна история)

Если вы хотите сохранить историю изменений через merge:

### Шаг 1: Создать резервную копию

```bash
git checkout master
git branch master-backup-$(date +%Y%m%d)
```

### Шаг 2: Merge laravel-migration в master

```bash
git checkout master
git merge laravel-migration --no-ff -m "Merge Laravel 12 migration into master"
```

### Шаг 3: Разрешить конфликты (если есть)

```bash
# Если есть конфликты, разрешите их вручную
git status
# Отредактируйте файлы с конфликтами
git add .
git commit -m "Resolve merge conflicts"
```

### Шаг 4: Отправить изменения

```bash
git push origin master
```

## ⚠️ Важно перед мержем/переименованием

1. **Проверьте, что все работает локально:**
   ```bash
   docker-compose up -d
   docker-compose exec app php artisan migrate:status
   docker-compose exec app php artisan route:list
   ```

2. **Убедитесь, что нет незакоммиченных изменений:**
   ```bash
   git status
   git diff
   ```

3. **Создайте тег для текущей версии (опционально):**
   ```bash
   git tag -a v12.0.0 -m "Laravel 12 migration completed"
   git push origin v12.0.0
   ```

## 🚀 После обновления master

### На продакшн-сервере:

```bash
# На сервере
cd /var/www/ampleev.com/blog
git fetch origin
git checkout master
git pull origin master

# Обновить зависимости (если нужно)
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📝 Рекомендация

**Я рекомендую использовать переименование ветки**, потому что:
- ✅ Чище история
- ✅ Меньше путаницы
- ✅ Старый master можно сохранить как backup
- ✅ Проще откатиться при проблемах

**Но сначала:**
1. Убедитесь, что `laravel-migration` полностью протестирована
2. Создайте резервную копию master
3. Проверьте работу на локальной машине

## 🔍 Проверка перед мержем

```bash
# Проверить различия
git diff master laravel-migration --stat

# Проверить коммиты
git log master..laravel-migration --oneline

# Проверить файлы
git diff master laravel-migration --name-only
```

