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

### Шаг 3: Отправить новую ветку master на GitHub

```bash
# Отправить новую ветку master (она будет называться master)
git push origin master

# Или если нужно установить upstream:
git push --set-upstream origin master
```

### Шаг 4: Изменить default branch на GitHub

**⚠️ ВАЖНО:** GitHub не позволяет удалить ветку, которая является default branch. Сначала нужно изменить default branch.

#### Вариант A: Через веб-интерфейс GitHub (рекомендуется)

1. Откройте репозиторий на GitHub: `https://github.com/eampleev23/ampleev.com`
2. Перейдите в **Settings** (настройки репозитория)
3. В левом меню выберите **Branches**
4. В разделе **Default branch** найдите текущую ветку `master`
5. Нажмите на иконку переключения (switch icon) рядом с `master`
6. Выберите ветку `master` (новая, которую вы только что отправили)
7. Нажмите **Update** и подтвердите изменение
8. GitHub может попросить подтвердить изменение default branch - нажмите **I understand, update the default branch**

#### Вариант B: Через GitHub CLI (если установлен)

```bash
gh repo edit eampleev23/ampleev.com --default-branch master
```

**Примечание:** После шага 3 у вас будет две ветки `master` на GitHub:
- Старая `master` (старый код Laravel 7) - все еще default branch
- Новая `master` (новый код Laravel 12) - которую вы только что отправили

После изменения default branch на новую `master`, можно удалить старую.

### Шаг 5: Удалить старую ветку master на GitHub

После того, как default branch изменена, можно удалить старую ветку:

**Вариант A: Через веб-интерфейс GitHub**

1. На странице репозитория перейдите в **Branches** (или `https://github.com/eampleev23/ampleev.com/branches`)
2. Найдите старую ветку `master` (та, что была default до изменения)
3. Нажмите на иконку корзины рядом с ней
4. Подтвердите удаление

**Вариант B: Через командную строку**

```bash
# Теперь можно удалить старую ветку master
git push origin --delete master
```

**⚠️ Внимание:** Если после шага 3 у вас уже есть новая ветка `master` на GitHub, то после изменения default branch старая и новая ветки `master` объединятся, и удалять ничего не нужно. Просто убедитесь, что default branch указывает на правильную версию.

### Шаг 6: Обновить удаленный репозиторий

**ВАЖНО:** GitHub не позволяет удалить ветку, которая является default branch. Сначала нужно изменить default branch.

#### 3.1. Сначала отправить новую ветку master на GitHub:

```bash
# Отправить новую ветку master (она будет называться master, но пока не будет default)
git push origin master

# Или если нужно установить upstream:
git push --set-upstream origin master
```

#### 3.2. Изменить default branch на GitHub:

1. Откройте репозиторий на GitHub: `https://github.com/eampleev23/ampleev.com`
2. Перейдите в **Settings** → **Branches**
3. В разделе **Default branch** нажмите на иконку переключения (switch icon)
4. Выберите ветку `laravel-migration` (или `master`, если вы уже переименовали локально)
5. Нажмите **Update** и подтвердите изменение

**Альтернатива через GitHub CLI (если установлен):**
```bash
gh repo edit eampleev23/ampleev.com --default-branch laravel-migration
```

#### 3.3. Теперь можно удалить старый master:

```bash
# Теперь можно удалить старый master
git push origin --delete master
```

**Примечание:** Если вы уже переименовали локальную ветку `laravel-migration` в `master`, то после шага 3.1 у вас будет две ветки `master` (старая и новая). После изменения default branch на GitHub, удалите старую ветку `master` через веб-интерфейс GitHub или подождите и удалите позже.

### Шаг 7: Очистка (опционально)

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

