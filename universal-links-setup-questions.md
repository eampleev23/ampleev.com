# Вопросы для бэкенда по настройке Universal Links

## Критические вопросы

### 1. Файл `apple-app-site-association`

**Вопрос:** Есть ли на сервере файл `apple-app-site-association` по адресу:
```
https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

**Что нужно проверить:**
- Файл должен быть доступен по HTTPS без редиректов
- Content-Type должен быть `application/json` (не `text/html`)
- Файл должен содержать правильный Bundle ID приложения: `com.ampleev.CheepCounter`
- Файл должен содержать правильные пути для обработки invite-кодов

**Если файла нет:** Нужно создать его с правильной структурой (см. инструкцию ниже)

---

### 2. App Store URL в HTML странице редиректа

**Вопрос:** Какой URL используется в кнопке "Скачать Points Counter" на странице `https://pointscounter.ampleev.com/{inviteCode}`?

**Текущая проблема:** При клике на кнопку показывается "Не удалось подключиться" в App Store.

**Нужно обновить на:**
```
https://apps.apple.com/ru/app/pointscounter/id6757125435
```

**Или универсальный URL (работает для всех регионов):**
```
https://apps.apple.com/app/id6757125435
```

---

### 3. Логика редиректа на бэкенде

**Вопрос:** Какая логика используется при открытии `https://pointscounter.ampleev.com/{inviteCode}`?

**Текущее поведение:**
- Если приложение установлено → редирект на `pointscounter://activity/join/{code}` (работает)
- Если приложение НЕ установлено → показывается HTML страница с кнопкой на App Store (работает, но ссылка неверная)

**Нужно уточнить:**
- Используется ли JavaScript для определения, установлено ли приложение?
- Или всегда показывается HTML страница с fallback на App Store?
- Через какое время показывается кнопка "Скачать Points Counter"?

---

### 4. Обработка Universal Links

**Вопрос:** Поддерживает ли бэкенд Universal Links (прямое открытие HTTPS-ссылок в приложении)?

**Текущая ситуация:**
- iOS приложение НЕ настроено для Universal Links (нет `associated-domains` в entitlements)
- Используется только Custom URL Scheme (`pointscounter://`)

**Нужно решить:**
- Нужны ли Universal Links для лучшего UX?
- Или достаточно Custom URL Scheme с правильным fallback на App Store?

**Рекомендация:** Universal Links дают лучший UX, так как:
- Ссылки открываются напрямую в приложении (без промежуточной страницы)
- После установки из App Store приложение автоматически открывается с правильным invite-кодом
- Работает даже если пользователь удалил и переустановил приложение

---

## Технические детали для бэкенда

### Структура файла `apple-app-site-association`

Если файла нет, нужно создать его со следующим содержимым:

```json
{
  "applinks": {
    "apps": [],
    "details": [
      {
        "appID": "TEAM_ID.com.ampleev.CheepCounter",
        "paths": [
          "/*"
        ]
      }
    ]
  }
}
```

**Важно:**
- `TEAM_ID` нужно заменить на реальный Team ID из Apple Developer (10 символов, например `ABC123DEF4`)
- `paths: ["/*"]` означает, что все пути на домене будут обрабатываться приложением
- Файл должен быть доступен БЕЗ редиректов
- Content-Type должен быть `application/json`

### Проверка файла

После создания файла можно проверить его:
```bash
curl -I https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

Должен вернуть:
```
HTTP/1.1 200 OK
Content-Type: application/json
```

---

## Что нужно сделать на бэкенде

1. ✅ **Обновить App Store URL** в HTML странице редиректа:
   - Заменить placeholder на реальный URL: `https://apps.apple.com/app/id6757125435`

2. ⚠️ **Создать файл `apple-app-site-association`** (если его нет):
   - Путь: `/.well-known/apple-app-site-association`
   - Формат: JSON
   - Content-Type: `application/json`
   - Содержимое: см. структуру выше

3. ✅ **Проверить логику редиректа**:
   - Убедиться, что при установленном приложении редирект на `pointscounter://` работает
   - Убедиться, что при НЕ установленном приложении показывается HTML страница с кнопкой на App Store

---

## Что нужно сделать в iOS приложении

1. ⚠️ **Добавить `associated-domains` в entitlements**:
   - Добавить домен: `applinks:pointscounter.ampleev.com`

2. ⚠️ **Добавить обработку Universal Links в SceneDelegate**:
   - Метод `scene(_:continue:)` для обработки `NSUserActivity` с типом `.browsingWeb`

3. ✅ **Проверить обработку Custom URL Scheme** (уже работает):
   - Метод `scene(_:openURLContexts:)` уже обрабатывает `pointscounter://`

---

## Приоритет задач

### Высокий приоритет (критично для работы):
1. Обновить App Store URL в HTML странице редиректа
2. Проверить, что редирект на `pointscounter://` работает при установленном приложении

### Средний приоритет (улучшение UX):
3. Создать файл `apple-app-site-association` на бэкенде
4. Добавить `associated-domains` в iOS приложение
5. Добавить обработку Universal Links в iOS приложение

---

## Тестирование

После настройки нужно протестировать:

1. **С установленным приложением:**
   - Открыть `https://pointscounter.ampleev.com/DY8TCY` в Safari
   - Должно открыться приложение с кодом `DY8TCY`

2. **Без установленного приложения:**
   - Открыть `https://pointscounter.ampleev.com/DY8TCY` в Safari
   - Должна показаться HTML страница с кнопкой "Скачать Points Counter"
   - Клик на кнопку должен открыть App Store с правильным приложением

3. **После установки из App Store:**
   - Установить приложение по ссылке из App Store
   - После установки приложение должно автоматически открыться с кодом `DY8TCY`

---

## Ответы, которые нужны от бэкенда

1. ✅ Есть ли файл `apple-app-site-association`? Если да, какой Team ID используется?
2. ✅ Какой URL используется в кнопке "Скачать Points Counter"?
3. ✅ Какая логика определения, установлено ли приложение?
4. ✅ Нужна ли поддержка Universal Links или достаточно Custom URL Scheme?
