# ТЗ: Настройка редиректов для ссылок-приглашений

**Дата создания:** 2026-01-02  
**Статус:** Требуется реализация

## Общее описание

Необходимо настроить редиректы для ссылок-приглашений на новый домен `pointscounter.ampleev.com` с новым форматом URL.

## Текущее состояние

**Старый формат (устарел):**
- `https://cheepcounter.ampleev.com/redirect.html?code={inviteCode}`
- Пример: `https://cheepcounter.ampleev.com/redirect.html?code=7H6VQH`

**Deep links (устарели):**
- `cheepcounter://activity/join/{inviteCode}`
- `cheepcounter://join/{inviteCode}`

## Требуемое состояние

**Новый формат ссылок-приглашений:**
- `https://pointscounter.ampleev.com/{inviteCode}`
- Пример: `https://pointscounter.ampleev.com/7H6VQH`

**Новые deep links:**
- `pointscounter://activity/join/{inviteCode}`
- `pointscounter://join/{inviteCode}`

## Важные замечания

⚠️ **API и WebSocket остаются на старом домене:**
- API: `https://cheepcounter.ampleev.com` (не менять)
- WebSocket: `wss://cheepcounter.ampleev.com` (не менять)
- **Только редиректы для присоединения** работают через новый домен `pointscounter.ampleev.com`

## Требования к реализации

### 1. Настройка нового домена

1.1. Настроить домен `pointscounter.ampleev.com`:
- Настроить DNS записи для домена
- Настроить SSL сертификат (HTTPS)
- Настроить веб-сервер (nginx/apache) для обработки запросов

### 2. Обработка нового формата URL

2.1. Обработка запросов вида `https://pointscounter.ampleev.com/{inviteCode}`:
- Извлечь `inviteCode` из пути URL
- Валидировать формат кода (6-10 символов, буквы/цифры, только заглавные)
- Если код валиден → редирект на deep link `pointscounter://activity/join/{inviteCode}`
- Если код невалиден → показать страницу с ошибкой или редирект на главную страницу приложения

2.2. Пример обработки:
```
GET https://pointscounter.ampleev.com/7H6VQH
→ Редирект на: pointscounter://activity/join/7H6VQH
```

### 3. Обратная совместимость (опционально)

3.1. Старый формат больше не поддерживается:
- Старые ссылки `https://cheepcounter.ampleev.com/redirect.html?code={inviteCode}` могут быть удалены или возвращать 404
- Старые deep links `cheepcounter://` больше не обрабатываются на клиенте

### 4. Валидация кода приглашения

4.1. Формат кода:
- Длина: 6-10 символов
- Символы: только заглавные буквы (A-Z) и цифры (0-9)
- Регистр: автоматически приводить к верхнему регистру

4.2. Примеры валидных кодов:
- `7H6VQH`
- `ABCD1234`
- `TEST123`

4.3. Примеры невалидных кодов:
- `7h6vqh` (строчные буквы - нужно приводить к верхнему регистру)
- `7H6VQ` (слишком короткий, меньше 6 символов)
- `7H6VQH12345` (слишком длинный, больше 10 символов)
- `7H6-VQH` (содержит недопустимые символы)

### 5. Редирект на deep link

5.1. Механизм редиректа:
- Использовать HTTP редирект с кодом 302 (временный редирект) или 301 (постоянный)
- В заголовке `Location` указать deep link: `pointscounter://activity/join/{inviteCode}`
- Альтернативно: можно использовать HTML страницу с JavaScript редиректом или meta refresh

5.2. Пример HTTP редиректа:
```
HTTP/1.1 302 Found
Location: pointscounter://activity/join/7H6VQH
```

5.3. Пример HTML редиректа (fallback):
```html
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=pointscounter://activity/join/7H6VQH">
    <script>
        window.location.href = "pointscounter://activity/join/7H6VQH";
    </script>
</head>
<body>
    <p>Перенаправление...</p>
</body>
</html>
```

### 6. Обработка ошибок

6.1. Невалидный код:
- Показать страницу с сообщением об ошибке
- Или редирект на главную страницу приложения/App Store

6.2. Несуществующий код:
- Показать страницу с сообщением, что код не найден
- Или редирект на главную страницу приложения/App Store

### 7. Тестирование

7.1. Проверить:
- ✅ Редирект с валидным кодом работает
- ✅ Невалидный код обрабатывается корректно
- ✅ Несуществующий код обрабатывается корректно
- ✅ Deep link открывается в приложении (если установлено)
- ✅ Если приложение не установлено, показывается страница с инструкцией или редирект в App Store

## Примеры реализации

### Nginx конфигурация

```nginx
server {
    listen 443 ssl;
    server_name pointscounter.ampleev.com;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location ~ ^/([A-Z0-9]{6,10})$ {
        set $code $1;
        return 302 pointscounter://activity/join/$code;
    }
    
    location / {
        return 404;
    }
}
```

### Node.js/Express пример

```javascript
app.get('/:code', (req, res) => {
    const code = req.params.code.toUpperCase();
    
    // Валидация кода
    if (!/^[A-Z0-9]{6,10}$/.test(code)) {
        return res.status(404).send('Invalid invite code');
    }
    
    // Редирект на deep link
    res.redirect(`pointscounter://activity/join/${code}`);
});
```

## Чеклист для реализации

- [ ] Настроить DNS для домена `pointscounter.ampleev.com`
- [ ] Настроить SSL сертификат
- [ ] Настроить веб-сервер для обработки запросов
- [ ] Реализовать извлечение кода из URL пути
- [ ] Реализовать валидацию кода
- [ ] Реализовать редирект на deep link
- [ ] Реализовать обработку ошибок (невалидный/несуществующий код)
- [ ] Протестировать редиректы с валидными кодами
- [ ] Протестировать обработку невалидных кодов
- [ ] Протестировать открытие deep links в приложении
- [ ] Протестировать поведение, если приложение не установлено

## Связанные изменения

- iOS приложение обновлено для поддержки нового формата ссылок и deep links
- Старый формат ссылок больше не используется в iOS приложении
- API и WebSocket остаются на старом домене `cheepcounter.ampleev.com`

