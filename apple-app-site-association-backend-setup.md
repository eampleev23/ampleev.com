# Инструкция по настройке файла apple-app-site-association на бэкенде

**Дата:** 2026-01-07  
**Bundle ID:** `com.ampleev.CheepCounter`  
**Team ID:** `4XT2YYJHT5`  
**App ID:** `4XT2YYJHT5.com.ampleev.CheepCounter`

---

## 📋 Данные для файла

### Bundle ID
```
com.ampleev.CheepCounter
```

### Team ID
```
4XT2YYJHT5
```

### App ID (Team ID + Bundle ID)
```
4XT2YYJHT5.com.ampleev.CheepCounter
```

---

## 📄 Содержимое файла

Файл `apple-app-site-association` должен содержать следующий JSON:

```json
{
  "applinks": {
    "apps": [],
    "details": [
      {
        "appID": "4XT2YYJHT5.com.ampleev.CheepCounter",
        "paths": [
          "/*"
        ]
      }
    ]
  }
}
```

**Важно:**
- Файл должен быть **валидным JSON** (без комментариев)
- `paths: ["/*"]` означает, что все пути на домене будут обрабатываться приложением
- `appID` состоит из `Team ID` + `.` + `Bundle ID`

---

## 📍 Путь к файлу

Файл должен быть доступен по адресу:
```
https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

**Требования:**
- ✅ Доступен по HTTPS (HTTP не поддерживается)
- ✅ Без редиректов (прямой доступ)
- ✅ Content-Type: `application/json` (не `text/html`)
- ✅ Без расширения `.json` в URL (но файл может иметь расширение `.json`)

---

## 🔧 Варианты реализации

### Вариант 1: Статический файл (рекомендуется)

**Для Laravel:**
1. Создать файл: `public/.well-known/apple-app-site-association`
2. Скопировать содержимое JSON (см. выше)
3. Убедиться, что файл доступен по HTTPS

**Проверка:**
```bash
curl -I https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

Должен вернуть:
```
HTTP/1.1 200 OK
Content-Type: application/json
```

---

### Вариант 2: Роут в Laravel (для динамической отдачи)

**Преимущества:**
- Можно динамически менять Bundle ID или Team ID
- Легче обновлять при изменении конфигурации

**Реализация в Laravel:**

1. **Создать роут в `routes/web.php`:**
```php
Route::get('/.well-known/apple-app-site-association', function () {
    return response()->json([
        'applinks' => [
            'apps' => [],
            'details' => [
                [
                    'appID' => '4XT2YYJHT5.com.ampleev.CheepCounter',
                    'paths' => ['/*']
                ]
            ]
        ]
    ], 200, [
        'Content-Type' => 'application/json',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});
```

2. **Или создать контроллер:**

`app/Http/Controllers/AppleAppSiteAssociationController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AppleAppSiteAssociationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'applinks' => [
                'apps' => [],
                'details' => [
                    [
                        'appID' => '4XT2YYJHT5.com.ampleev.CheepCounter',
                        'paths' => ['/*']
                    ]
                ]
            ]
        ], 200, [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }
}
```

`routes/web.php`:
```php
Route::get('/.well-known/apple-app-site-association', [AppleAppSiteAssociationController::class, 'index']);
```

---

## ⚙️ Настройка Nginx (если используется)

Если используется Nginx, нужно убедиться, что файл отдается с правильным Content-Type:

```nginx
location /.well-known/apple-app-site-association {
    default_type application/json;
    add_header Content-Type application/json;
    add_header Cache-Control "public, max-age=3600";
    
    # Если файл статический
    alias /path/to/public/.well-known/apple-app-site-association;
    
    # Или если через Laravel
    try_files $uri $uri/ /index.php?$query_string;
}
```

---

## ✅ Проверка после настройки

### 1. Проверка доступности

```bash
curl -I https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

**Ожидаемый результат:**
```
HTTP/1.1 200 OK
Content-Type: application/json
Cache-Control: public, max-age=3600
```

### 2. Проверка содержимого

```bash
curl https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

**Ожидаемый результат:**
```json
{
  "applinks": {
    "apps": [],
    "details": [
      {
        "appID": "4XT2YYJHT5.com.ampleev.CheepCounter",
        "paths": ["/*"]
      }
    ]
  }
}
```

### 3. Проверка валидности JSON

```bash
curl https://pointscounter.ampleev.com/.well-known/apple-app-site-association | jq .
```

Если `jq` установлен, должен вернуть отформатированный JSON без ошибок.

### 4. Проверка через браузер

Открыть в браузере:
```
https://pointscounter.ampleev.com/.well-known/apple-app-site-association
```

**Ожидаемый результат:**
- JSON отображается в браузере
- Нет ошибок 404 или 500
- Content-Type правильный

---

## 🚨 Важные замечания

### 1. Content-Type обязателен

Файл **должен** отдаваться с `Content-Type: application/json`. Если отдается как `text/html`, iOS не распознает его.

### 2. Без редиректов

Файл должен быть доступен **напрямую**, без редиректов (301, 302). iOS не следует редиректам для этого файла.

### 3. HTTPS обязателен

Universal Links работают **только по HTTPS**. HTTP не поддерживается.

### 4. Кэширование

iOS кэширует файл `apple-app-site-association`. Если файл изменился, может потребоваться:
- Переустановка приложения
- Очистка кэша iOS (Settings → Safari → Clear History and Website Data)

### 5. Валидный JSON

Файл должен быть **валидным JSON**:
- ✅ Без комментариев
- ✅ Правильные кавычки (двойные)
- ✅ Правильная структура

---

## 📝 Чеклист настройки

- [ ] Создать файл `apple-app-site-association` (статический или через роут)
- [ ] Убедиться, что файл доступен по HTTPS
- [ ] Убедиться, что Content-Type: `application/json`
- [ ] Убедиться, что нет редиректов
- [ ] Проверить валидность JSON
- [ ] Протестировать доступность через `curl`
- [ ] Протестировать в браузере

---

## 🔗 Связанные документы

- `apple-app-site-association.json` - Готовый файл для копирования
- `universal-links-backend-checklist.md` - Общий чеклист для бэкенда
- `universal-links-ios-setup.md` - Настройка в iOS приложении

---

## 💡 Рекомендация

**Рекомендую использовать Вариант 1 (статический файл):**
- ✅ Проще в настройке
- ✅ Быстрее работает (нет обработки через PHP)
- ✅ Меньше нагрузка на сервер
- ✅ Легче кэшировать

**Используйте Вариант 2 (роут) только если:**
- Нужно динамически менять Bundle ID или Team ID
- Есть несколько приложений с разными Bundle ID
- Нужна дополнительная логика при отдаче файла
