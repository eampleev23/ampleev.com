# Инструкция по обновлению Laravel 7 → 12 на продакшн-сервере

## 📋 Информация о продакшн-окружении

- **Хостинг**: Simplecloud (VPS)
- **Доступ**: Root доступ по SSH
- **Текущая версия PHP**: 7.4.33
- **Текущая версия Laravel**: 7.28.4
- **Composer**: Не установлен (нужно установить)
- **Деплой**: `git pull origin master`
- **Путь к проекту**: `/var/www/ampleev.com/blog`
- **Downtime**: Разрешен
- **Очереди**: Не используются активно
- **Cron задачи**: Нет запланированных задач

---

## ⚠️ ВАЖНО: Перед началом

1. **Создайте полный бэкап:**
   ```bash
   # На сервере
   cd /var/www/ampleev.com/blog
   
   # Бэкап базы данных
   mysqldump -u root -p laravel > backup_$(date +%Y%m%d_%H%M%S).sql
   
   # Бэкап кода
   tar -czf backup_code_$(date +%Y%m%d_%H%M%S).tar.gz .
   
   # Бэкап .env файла
   cp .env .env.backup_$(date +%Y%m%d_%H%M%S)
   ```

2. **Проверьте текущее состояние:**
   ```bash
   php -v
   php artisan --version
   ```

---

## 📦 Шаг 1: Установка Composer

```bash
# Установить Composer
cd /tmp
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Проверить установку
composer --version
```

---

## 🔧 Шаг 2: Обновление PHP с 7.4 до 8.2

### 2.1. Добавить репозиторий PHP 8.2

```bash
# Для Debian/Ubuntu
apt update
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
```

### 2.2. Установить PHP 8.2 и расширения

```bash
# Установить PHP 8.2 и необходимые расширения
apt install -y php8.2-fpm php8.2-cli php8.2-common php8.2-mysql \
    php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd \
    php8.2-bcmath php8.2-intl php8.2-opcache

# Проверить версию
php8.2 -v
```

### 2.3. Обновить конфигурацию веб-сервера

```bash
# Если используется Nginx + PHP-FPM
# Обновить конфигурацию Nginx для использования php8.2-fpm
# Обычно файл находится в /etc/nginx/sites-available/ampleev.com

# Найти текущую конфигурацию
grep -r "php7.4-fpm\|php-fpm" /etc/nginx/

# Обновить путь к PHP-FPM в конфигурации Nginx
# Заменить: fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
# На: fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
```

### 2.4. Перезапустить сервисы

```bash
# Перезапустить PHP-FPM
systemctl restart php8.2-fpm

# Перезапустить Nginx
systemctl restart nginx

# Проверить статус
systemctl status php8.2-fpm
systemctl status nginx
```

---

## 🔄 Шаг 3: Обновление кода из Git

```bash
cd /var/www/ampleev.com/blog

# Переключиться на ветку laravel-migration
git fetch origin
git checkout laravel-migration

# Или если нужно смержить в master:
# git checkout master
# git merge laravel-migration
```

---

## 📥 Шаг 4: Обновление зависимостей

```bash
cd /var/www/ampleev.com/blog

# Удалить старые зависимости (если нужно)
rm -rf vendor composer.lock

# Установить зависимости
composer install --no-dev --optimize-autoloader

# Если будут ошибки с правами доступа:
# chown -R www-data:www-data /var/www/ampleev.com/blog
# chmod -R 755 /var/www/ampleev.com/blog
```

---

## 🔑 Шаг 5: Обновление .env файла

```bash
cd /var/www/ampleev.com/blog

# Проверить .env файл
cat .env

# Убедиться что есть APP_KEY
# Если нет, сгенерировать:
php artisan key:generate

# Проверить настройки БД
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1 (или localhost)
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=ваш_пароль
```

---

## 🗄️ Шаг 6: Обновление базы данных

```bash
cd /var/www/ampleev.com/blog

# Очистить кеш перед миграциями
php artisan config:clear
php artisan cache:clear

# Запустить миграции
php artisan migrate --force

# Если будут ошибки с doctrine/dbal:
# Возможно нужно будет временно пропустить проблемную миграцию
# или обновить её вручную
```

---

## 🧹 Шаг 7: Очистка кеша и оптимизация

```bash
cd /var/www/ampleev.com/blog

# Очистить все кеши
php artisan optimize:clear

# Оптимизировать для продакшна
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Оптимизировать автозагрузку
composer dump-autoload --optimize --classmap-authoritative
```

---

## ✅ Шаг 8: Проверка работоспособности

```bash
# Проверить версию Laravel
php artisan --version
# Должно быть: Laravel Framework 12.x

# Проверить версию PHP
php -v
# Должно быть: PHP 8.2.x

# Проверить логи на ошибки
tail -f storage/logs/laravel.log

# Проверить сайт в браузере
# Откройте https://ampleev.com и проверьте что все работает
```

---

## 🔄 Шаг 9: Откат (если что-то пошло не так)

```bash
cd /var/www/ampleev.com/blog

# Откатить миграции (если нужно)
php artisan migrate:rollback

# Восстановить старую версию кода
git checkout master
# или
git reset --hard HEAD~1

# Восстановить старый PHP
systemctl stop php8.2-fpm
systemctl start php7.4-fpm
# Обновить конфигурацию Nginx обратно на php7.4-fpm
systemctl restart nginx

# Восстановить базу данных из бэкапа
mysql -u root -p laravel < backup_YYYYMMDD_HHMMSS.sql
```

---

## 📝 Чеклист после обновления

- [ ] PHP версия: 8.2.x
- [ ] Laravel версия: 12.x
- [ ] Сайт открывается без ошибок
- [ ] Все страницы работают (главная, блог, статьи)
- [ ] Комментарии работают
- [ ] Форма подписки работает
- [ ] Авторизация работает
- [ ] Нет ошибок в логах (`storage/logs/laravel.log`)
- [ ] Производительность в норме

---

## ⚠️ Возможные проблемы и решения

### Проблема: Ошибка "Class not found" или "Method not found"

**Решение:**
```bash
composer dump-autoload --optimize
php artisan optimize:clear
php artisan config:cache
```

### Проблема: Ошибки с правами доступа

**Решение:**
```bash
chown -R www-data:www-data /var/www/ampleev.com/blog
chmod -R 755 /var/www/ampleev.com/blog
chmod -R 775 /var/www/ampleev.com/blog/storage
chmod -R 775 /var/www/ampleev.com/blog/bootstrap/cache
```

### Проблема: Ошибка подключения к БД

**Решение:**
- Проверить настройки в `.env`
- Проверить что MySQL запущен: `systemctl status mysql`
- Проверить доступ к БД: `mysql -u root -p`

### Проблема: Белый экран (500 ошибка)

**Решение:**
```bash
# Включить отображение ошибок временно
# В .env установить: APP_DEBUG=true

# Проверить логи
tail -50 storage/logs/laravel.log

# Проверить права на storage
chmod -R 775 storage bootstrap/cache
```

---

## 📞 Поддержка

Если возникнут проблемы:
1. Проверьте логи: `tail -f storage/logs/laravel.log`
2. Проверьте логи Nginx: `/var/log/nginx/error.log`
3. Проверьте логи PHP-FPM: `/var/log/php8.2-fpm.log`

---

## 🎉 После успешного обновления

1. Обновите `.cursorcontext` с новой версией Laravel
2. Удалите старые бэкапы (через неделю после проверки)
3. Наслаждайтесь улучшенной производительностью! 🚀

