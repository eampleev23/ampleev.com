# Инструкция по настройке pointscounter.ampleev.com

## Шаг 1: Добавление DNS записи в Cloudflare

1. Войдите в панель Cloudflare для домена `ampleev.com`
2. Перейдите в раздел **DNS** → **Records**
3. Нажмите **Add record**
4. Заполните:
   - **Type**: `A`
   - **Name**: `pointscounter`
   - **IPv4 address**: `212.193.50.194`
   - **Proxy status**: `DNS only` (серое облачко, не оранжевое)
   - **TTL**: `Auto`
5. Нажмите **Save**

**Важно**: Cloudflare проксирование должно быть выключено (серое облачко), так как мы не используем Cloudflare для этого поддомена.

## Шаг 2: Создание SSL сертификата через Certbot

После добавления DNS записи подождите 5-10 минут для распространения DNS, затем выполните на сервере:

```bash
# Создание SSL сертификата для поддомена
certbot certonly --nginx -d pointscounter.ampleev.com

# Или если certbot не может автоматически настроить nginx:
certbot certonly --webroot -w /var/www/ampleev.com/blog/public -d pointscounter.ampleev.com
```

## Шаг 3: Создание Nginx конфигурации

Создайте файл `/etc/nginx/sites-available/pointscounter.ampleev.com`:

```nginx
server {
    server_name pointscounter.ampleev.com;
    root /var/www/ampleev.com/blog/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        
        # Передаем код страны в PHP через fastcgi_param
        fastcgi_param GEOIP2_COUNTRY_CODE $geoip2_country_code;
    }

    location ~ /\.ht {
        deny all;
    }

    error_log /var/log/nginx/pointscounter.ampleev.com_error.log;
    access_log /var/log/nginx/pointscounter.ampleev.com_access.log;

    listen 443 ssl;
    listen [::]:443 ssl ipv6only=on;
    
    ssl_certificate /etc/letsencrypt/live/pointscounter.ampleev.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/pointscounter.ampleev.com/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;
    
    # Дополнительные настройки для лучшей совместимости с TLS 1.3
    ssl_ecdh_curve X25519:P-256:P-384:P-521;
}

server {
    if ($host = pointscounter.ampleev.com) {
        return 301 https://$host$request_uri;
    }
    
    listen 80;
    listen [::]:80;
    server_name pointscounter.ampleev.com;
    return 404;
}
```

## Шаг 4: Активация конфигурации Nginx

```bash
# Создание символической ссылки
ln -s /etc/nginx/sites-available/pointscounter.ampleev.com /etc/nginx/sites-enabled/

# Проверка конфигурации
nginx -t

# Перезагрузка Nginx
systemctl reload nginx
```

## Шаг 5: Проверка работы

```bash
# Проверка DNS
nslookup pointscounter.ampleev.com

# Проверка доступности
curl -I https://pointscounter.ampleev.com

# Проверка SSL
openssl s_client -connect pointscounter.ampleev.com:443 -servername pointscounter.ampleev.com < /dev/null 2>/dev/null | openssl x509 -noout -dates
```

## Шаг 6: Автоматическое обновление SSL сертификата

Certbot автоматически настроит обновление через cron. Проверить можно командой:

```bash
certbot renew --dry-run
```

## Готово!

После выполнения всех шагов страница будет доступна по адресу:
- **https://pointscounter.ampleev.com**

Страница использует тот же layout, что и основной сайт, но с пустым контентом (пока).

## Примечания

- Если DNS запись не распространилась, подождите еще несколько минут
- Если SSL сертификат не создается, убедитесь, что DNS запись активна: `nslookup pointscounter.ampleev.com`
- Если возникают проблемы с Nginx, проверьте логи: `tail -50 /var/log/nginx/pointscounter.ampleev.com_error.log`

