# Настройка SMTP для отправки уведомлений

## 📧 Настройки для разных почтовых сервисов

### Вариант 1: Яндекс.Почта (рекомендуется для России)

**📚 Официальная документация:** https://yandex.ru/support/yandex-360/customers/mail/ru/mail-clients/others.html

Отредактируйте `.env` файл на сервере:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=465
MAIL_USERNAME=ваш_email@yandex.ru
MAIL_PASSWORD=ваш_пароль_приложения
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=ваш_email@yandex.ru
MAIL_FROM_NAME="Ampleev.com"
```

**Важно для Яндекс.Почты:**
1. **Пароль приложения (обязательно!)**:
   - НЕ используйте основной пароль от аккаунта
   - Создайте пароль приложения: https://id.yandex.ru/security/app-passwords
   - Выберите "Почта" при создании пароля
   - Используйте этот пароль в `MAIL_PASSWORD`

2. **Настройки доступа в Яндекс.Почте**:
   - Откройте: https://mail.yandex.ru/?dpda=yes#setup/client
   - Включите опцию "С сервера imap.yandex.ru по протоколу IMAP" (даже для SMTP)
   - Включите опцию "Пароли приложений и OAuth-токены"
   - Сохраните изменения

3. **Порты и шифрование** (согласно официальной документации):
   - **465** — используется с **SSL** (рекомендуется)
   - **587** — используется с **TLS** (если клиент начинает без шифрования)

**⚠️ Примечание:** Параметр `MAIL_DRIVER=smtp` не нужен в Laravel 12, используется только `MAIL_MAILER=smtp`.

### Вариант 2: Gmail

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ваш_email@gmail.com
MAIL_PASSWORD=ваш_пароль_приложения
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=ваш_email@gmail.com
MAIL_FROM_NAME="Ampleev.com"
```

**Важно для Gmail:**
1. Нужно включить "Ненадежные приложения" или создать пароль приложения:
   - Зайдите в https://myaccount.google.com/security
   - Включите "Двухэтапную аутентификацию"
   - Создайте "Пароль приложения" для "Почта"
   - Используйте этот пароль в `MAIL_PASSWORD`

### Вариант 3: Mail.ru

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.ru
MAIL_PORT=465
MAIL_USERNAME=ваш_email@mail.ru
MAIL_PASSWORD=ваш_пароль
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=ваш_email@mail.ru
MAIL_FROM_NAME="Ampleev.com"
```

### Вариант 4: SendGrid (для продакшена)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=ваш_SendGrid_API_ключ
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ampleev.com
MAIL_FROM_NAME="Ampleev.com"
```

## 🔧 Шаги настройки на сервере

1. **Отредактируйте `.env` файл:**
   ```bash
   cd /var/www/ampleev.com/blog
   nano .env
   ```

2. **Обновите настройки почты** (выберите один из вариантов выше)

3. **Очистите и пересоздайте кеш конфигурации:**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

4. **Протестируйте отправку:**
   ```bash
   php artisan tinker
   ```
   Затем в tinker:
   ```php
   Mail::raw('Test message', function ($message) {
       $message->to('ваш_email@example.com')
                ->subject('Test Email');
   });
   ```

## ⚠️ Важные замечания

- **Пароли приложений**: Для Gmail и Яндекс.Почты нужны специальные пароли приложений, не основной пароль аккаунта
- **Безопасность**: Никогда не коммитьте `.env` файл в Git
- **Лимиты**: Бесплатные аккаунты имеют лимиты на отправку (Gmail: 500/день, Яндекс: 500/день)
- **SPF/DKIM**: Для лучшей доставляемости настройте SPF и DKIM записи в DNS

## 🧪 Проверка работы

После настройки попробуйте оставить комментарий на сайте - автор статьи должен получить email-уведомление.

Если есть ошибки, проверьте логи:
```bash
tail -50 storage/logs/laravel-$(date +%Y-%m-%d).log
```

