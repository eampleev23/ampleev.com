# ✅ Чеклист проверки настроек SMTP для Яндекс.Почты

## 📋 Ваши текущие настройки (из вопроса)

```env
MAIL_MAILER=smtp          ✅ Правильно
MAIL_HOST=smtp.yandex.ru ✅ Правильно
MAIL_PORT=465            ✅ Правильно
MAIL_USERNAME=eampleev@yandex.ru ✅ Правильно
MAIL_PASSWORD=***         ⚠️ ТРЕБУЕТ ПРОВЕРКИ
MAIL_ENCRYPTION=ssl      ✅ Правильно для порта 465
MAIL_FROM_ADDRESS=eampleev@yandex.ru ✅ Правильно
MAIL_FROM_NAME="Ampleev.com" ✅ Правильно
MAIL_DRIVER=smtp         ❌ НЕ НУЖЕН (можно удалить из .env)
```

## 🔍 Что проверить пошагово

### 1. ✅ Параметр MAIL_DRIVER
- **Статус:** Не нужен в Laravel 12
- **Действие:** Удалите строку `MAIL_DRIVER=smtp` из `.env` (если она есть)
- **Почему:** В Laravel 12 используется только `MAIL_MAILER`, параметр `MAIL_DRIVER` устарел

### 2. ⚠️ Пароль приложения (КРИТИЧНО!)
- **Статус:** Требует проверки
- **Действие:** 
  1. Откройте https://id.yandex.ru/security/app-passwords
  2. Убедитесь, что у вас есть пароль приложения для "Почта"
  3. Если нет — создайте новый:
     - Нажмите "Создать пароль приложения"
     - Выберите "Почта"
     - Придумайте название (например, "Laravel SMTP")
     - Скопируйте созданный пароль
  4. Убедитесь, что в `.env` используется именно пароль приложения, а НЕ основной пароль аккаунта

### 3. ✅ Настройки доступа в Яндекс.Почте
- **Статус:** Требует проверки
- **Действие:**
  1. Откройте https://mail.yandex.ru/?dpda=yes#setup/client
  2. В разделе "Разрешить доступ к почтовому ящику с помощью почтовых клиентов":
     - ✅ Включите "С сервера imap.yandex.ru по протоколу IMAP" (даже для SMTP!)
     - ✅ Включите "Пароли приложений и OAuth-токены"
  3. Сохраните изменения

### 4. ✅ Порты и шифрование
- **Статус:** Правильно настроено
- **Текущие настройки:**
  - Порт: 465 ✅
  - Шифрование: ssl ✅
- **Альтернатива (если 465 не работает):**
  - Порт: 587
  - Шифрование: tls

### 5. ✅ Очистка кеша Laravel
- **Действие:** После изменения `.env` выполните:
  ```bash
  cd /var/www/ampleev.com/blog
  php artisan config:clear
  php artisan config:cache
  ```

## 📚 Официальные источники

1. **Основная документация:** https://yandex.ru/support/yandex-360/customers/mail/ru/mail-clients/others.html
2. **Пароли приложений:** https://id.yandex.ru/security/app-passwords
3. **Настройки доступа:** https://mail.yandex.ru/?dpda=yes#setup/client

## 🧪 Тестирование

После проверки всех пунктов протестируйте отправку:

```bash
cd /var/www/ampleev.com/blog
php artisan tinker
```

В tinker:
```php
use Illuminate\Support\Facades\Mail;

Mail::raw('Тестовое сообщение', function ($message) {
    $message->to('ваш_email@example.com')
             ->subject('Тест SMTP');
});
```

Если ошибка "Invalid user or password!" или "This user does not have access rights":
- Проверьте, что используете пароль приложения, а не основной пароль
- Проверьте настройки доступа в Яндекс.Почте
- Убедитесь, что включены "Пароли приложений и OAuth-токены"

## 📝 Итоговый правильный .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=465
MAIL_USERNAME=eampleev@yandex.ru
MAIL_PASSWORD=ваш_пароль_приложения_из_https://id.yandex.ru/security/app-passwords
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=eampleev@yandex.ru
MAIL_FROM_NAME="Ampleev.com"
```

**Не включайте:**
- ❌ `MAIL_DRIVER=smtp` (устаревший параметр)

