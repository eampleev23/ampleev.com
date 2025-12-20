# Официальные настройки SMTP для Яндекс.Почты

## 📚 Источник
Официальная документация Яндекса: https://yandex.ru/support/yandex-360/customers/mail/ru/mail-clients/others.html

## ✅ Правильные настройки SMTP

### Для порта 465 (SSL - рекомендуется):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=465
MAIL_USERNAME=eampleev@yandex.ru
MAIL_PASSWORD=пароль_приложения
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=eampleev@yandex.ru
MAIL_FROM_NAME="Ampleev.com"
```

### Для порта 587 (TLS - альтернатива):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=587
MAIL_USERNAME=eampleev@yandex.ru
MAIL_PASSWORD=пароль_приложения
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=eampleev@yandex.ru
MAIL_FROM_NAME="Ampleev.com"
```

## 🔑 Важные моменты

1. **Пароль приложения (обязательно!)**:
   - НЕ используйте основной пароль от аккаунта
   - Создайте пароль приложения: https://id.yandex.ru/security/app-passwords
   - Выберите "Почта" при создании пароля

2. **Настройки в Яндекс.Почте**:
   - Включите доступ: https://mail.yandex.ru/?dpda=yes#setup/client
   - Включите опцию "С сервера imap.yandex.ru по протоколу IMAP" (даже для SMTP)
   - Включите опцию "Пароли приложений и OAuth-токены"

3. **Порты и шифрование**:
   - **465** — используется с **SSL** (рекомендуется)
   - **587** — используется с **TLS** (если клиент начинает без шифрования)

## ❌ Что НЕ нужно

- `MAIL_DRIVER=smtp` — это устаревший параметр для старых версий Laravel
- В Laravel 12 используется только `MAIL_MAILER=smtp`

## 📋 Текущие настройки (проверьте)

Ваши текущие настройки:
```env
MAIL_MAILER=smtp          ✅ Правильно
MAIL_HOST=smtp.yandex.ru ✅ Правильно
MAIL_PORT=465            ✅ Правильно
MAIL_USERNAME=eampleev@yandex.ru ✅ Правильно
MAIL_PASSWORD=***         ⚠️ Должен быть пароль приложения, не основной пароль
MAIL_ENCRYPTION=ssl      ✅ Правильно для порта 465
MAIL_FROM_ADDRESS=eampleev@yandex.ru ✅ Правильно
MAIL_FROM_NAME="Ampleev.com" ✅ Правильно
MAIL_DRIVER=smtp         ❌ Не нужен в Laravel 12 (можно удалить)
```

## 🔧 Что проверить

1. **Пароль приложения**:
   - Убедитесь, что используете пароль приложения, а не основной пароль
   - Если не уверены, создайте новый: https://id.yandex.ru/security/app-passwords

2. **Настройки доступа в Яндекс.Почте**:
   - Проверьте: https://mail.yandex.ru/?dpda=yes#setup/client
   - Должны быть включены:
     - "С сервера imap.yandex.ru по протоколу IMAP"
     - "Пароли приложений и OAuth-токены"

3. **Очистка кеша Laravel**:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

## 📖 Ссылки на официальную документацию

- Основная страница: https://yandex.ru/support/yandex-360/customers/mail/ru/mail-clients/others.html
- Пароли приложений: https://id.yandex.ru/security/app-passwords
- Настройки доступа: https://mail.yandex.ru/?dpda=yes#setup/client

