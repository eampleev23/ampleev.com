# Ответы на вопросы бэкенда по настройке Universal Links

**Дата:** 2026-01-07  
**Текущая версия в App Store:** 1.5.x (без Universal Links)  
**Будущая версия:** 1.6.0+ (с Universal Links)

---

## 1. Логика определения установки приложения

### Ответ: **Вариант A** (для текущей версии) + **Universal Links** (для будущей версии)

### Для текущей версии (1.5.x в App Store):

**Вариант A:** Сначала пробовать открыть deep link (`pointscounter://`), и если через N секунд не открылось → редирект в App Store.

**Реализация:**
```javascript
// Псевдокод
function handleInviteCode(code) {
    // Пытаемся открыть deep link
    window.location.href = `pointscounter://activity/join/${code}`;
    
    // Устанавливаем таймер на 2-3 секунды
    setTimeout(() => {
        // Если приложение не открылось, показываем кнопку App Store
        showAppStoreButton(code);
    }, 2500);
}
```

**Почему этот вариант:**
- ✅ Если приложение установлено → открывается сразу
- ✅ Если не установлено → показывается кнопка App Store
- ✅ Работает для текущей версии без Universal Links

### Для будущей версии (1.6.0+ с Universal Links):

**Universal Links работают автоматически:**
- iOS сам определяет, установлено ли приложение
- Если установлено → открывается приложение напрямую
- Если не установлено → показывается HTML страница (fallback)

**На бэкенде ничего делать не нужно** - Universal Links обрабатываются iOS автоматически.

---

## 2. Сохранение кода приглашения после установки

### Ответ: **Вариант D** (Universal Links решают автоматически) + **Вариант B** (для текущей версии)

### Для будущей версии (1.6.0+ с Universal Links):

**Вариант D:** Universal Links решают эту проблему автоматически.

**Как это работает:**
1. Пользователь открывает `https://pointscounter.ampleev.com/DY8TCY`
2. Если приложение не установлено → показывается HTML страница с кнопкой App Store
3. Пользователь устанавливает приложение из App Store
4. **iOS автоматически запоминает Universal Link**
5. После установки приложение автоматически открывается с правильным URL
6. Приложение извлекает код `DY8TCY` из URL и присоединяется к игре

**На бэкенде ничего делать не нужно** - iOS сам обрабатывает это.

### Для текущей версии (1.5.x без Universal Links):

**Вариант B:** Сохранять код в localStorage, а после возврата проверять и открывать deep link.

**Реализация:**
```javascript
// При редиректе в App Store
function redirectToAppStore(code) {
    // Сохраняем код в localStorage
    localStorage.setItem('pendingInviteCode', code);
    localStorage.setItem('pendingInviteTimestamp', Date.now());
    
    // Редирект в App Store
    window.location.href = `https://apps.apple.com/app/id6757125435`;
}

// При возврате на страницу (после установки)
function checkPendingInvite() {
    const code = localStorage.getItem('pendingInviteCode');
    const timestamp = localStorage.getItem('pendingInviteTimestamp');
    
    // Проверяем, что код не старше 1 часа
    if (code && timestamp && (Date.now() - timestamp < 3600000)) {
        // Пытаемся открыть deep link
        window.location.href = `pointscounter://activity/join/${code}`;
        
        // Очищаем localStorage
        localStorage.removeItem('pendingInviteCode');
        localStorage.removeItem('pendingInviteTimestamp');
    }
}

// Вызывать при загрузке страницы
window.addEventListener('load', checkPendingInvite);
```

**Альтернатива (проще):**
Можно также показывать кнопку "Присоединиться к игре" с кодом после возврата из App Store (Вариант C).

---

## 3. Поведение после возврата из App Store

### Ответ: **Автоматически пытаться открыть deep link** (для текущей версии) + **Universal Links** (для будущей версии)

### Для будущей версии (1.6.0+ с Universal Links):

**Автоматически:** Universal Links автоматически откроют приложение после установки.

**На бэкенде ничего делать не нужно** - iOS сам обрабатывает это.

### Для текущей версии (1.5.x без Universal Links):

**Автоматически пытаться открыть deep link:**

```javascript
// При возврате на страницу
function handleReturnFromAppStore() {
    // Проверяем, есть ли сохраненный код
    const code = localStorage.getItem('pendingInviteCode');
    
    if (code) {
        // Автоматически пытаемся открыть deep link
        window.location.href = `pointscounter://activity/join/${code}`;
        
        // Показываем сообщение на случай, если приложение еще не установлено
        setTimeout(() => {
            showMessage("Если приложение установлено, оно должно открыться автоматически. Если нет, нажмите кнопку ниже.");
        }, 1000);
    }
}
```

**Fallback:** Если deep link не открылся (приложение еще не установлено), показывать кнопку "Присоединиться к игре" с кодом.

---

## 4. Определение iOS устройства

### Ответ: **User-Agent достаточно, различать iPhone/iPad не нужно**

**Реализация:**
```javascript
function isIOS() {
    const userAgent = window.navigator.userAgent.toLowerCase();
    return /iphone|ipad|ipod/.test(userAgent);
}
```

**Или более точная проверка:**
```javascript
function isIOS() {
    const userAgent = window.navigator.userAgent.toLowerCase();
    return /iphone|ipad|ipod/.test(userAgent) || 
           (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1); // iPad на iOS 13+
}
```

**Достаточно общего "iOS":**
- ✅ Не нужно различать iPhone и iPad
- ✅ Оба используют одинаковый App Store URL
- ✅ Оба поддерживают Universal Links одинаково

---

## 5. Текущая версия vs будущая (Universal Links)

### Ответ: **Поддержка обеих версий** (рекомендуется) или **только текущей** (минимальный вариант)

### Вариант 1: Поддержка обеих версий (рекомендуется)

**Логика:**
1. Проверяем, поддерживает ли устройство Universal Links (iOS 9+)
2. Если да → используем Universal Links (работает для обеих версий)
3. Если нет или для обратной совместимости → используем Custom URL Scheme

**Реализация:**
```javascript
function handleInviteCode(code) {
    // Universal Links работают для всех версий iOS 9+
    // iOS сам определит, установлено ли приложение
    
    // Показываем HTML страницу с кнопкой App Store
    // iOS автоматически попытается открыть приложение через Universal Links
    // Если не установлено → показывается кнопка App Store
    
    showInvitePage(code);
}

function showInvitePage(code) {
    // Показываем страницу с кодом
    // iOS автоматически попытается открыть приложение через Universal Links
    // Если не установлено → показывается кнопка App Store
    
    // Также добавляем fallback на Custom URL Scheme для старых версий
    setTimeout(() => {
        window.location.href = `pointscounter://activity/join/${code}`;
    }, 100);
}
```

**Преимущества:**
- ✅ Работает для текущей версии (через Custom URL Scheme)
- ✅ Работает для будущей версии (через Universal Links)
- ✅ Автоматически переключается между версиями

### Вариант 2: Только текущая версия (минимальный вариант)

**Логика:**
- Использовать только Custom URL Scheme
- После перевыпуска Universal Links заработают автоматически (iOS сам обработает)

**Реализация:**
```javascript
function handleInviteCode(code) {
    // Пытаемся открыть deep link
    window.location.href = `pointscounter://activity/join/${code}`;
    
    // Если не открылось → показываем кнопку App Store
    setTimeout(() => {
        showAppStoreButton(code);
    }, 2500);
}
```

**Преимущества:**
- ✅ Проще реализация
- ✅ Работает для текущей версии
- ⚠️ После перевыпуска Universal Links все равно заработают (iOS сам обработает)

### Рекомендация: **Вариант 1** (поддержка обеих версий)

**Почему:**
- ✅ Лучший UX для обеих версий
- ✅ Universal Links работают сразу после перевыпуска
- ✅ Обратная совместимость с текущей версией

---

## 6. Сообщение для не-iOS устройств

### Ответ: **Показывать вместо кнопки App Store** + **Кнопка "Вернуться на главную"**

**Реализация:**
```html
<div id="invite-page">
    <h1>Открываем игру...</h1>
    <p>Код приглашения: <strong>DY8TCY</strong></p>
    
    <div id="ios-section" style="display: none;">
        <p>Перенаправляем вас в приложение для присоединения к игре</p>
        <button id="app-store-button">📲 Скачать Points Counter</button>
    </div>
    
    <div id="non-ios-section" style="display: none;">
        <p>К сожалению, на вашем устройстве приложение пока не доступно. Вас может добавить к игре организатор.</p>
        <button onclick="window.location.href='/'">Вернуться на главную</button>
    </div>
</div>

<script>
function showInvitePage(code) {
    if (isIOS()) {
        document.getElementById('ios-section').style.display = 'block';
        document.getElementById('app-store-button').onclick = () => {
            redirectToAppStore(code);
        };
    } else {
        document.getElementById('non-ios-section').style.display = 'block';
    }
}
</script>
```

**Где показывать:**
- ✅ Вместо кнопки App Store (для не-iOS устройств)
- ✅ Кнопка "Вернуться на главную" для навигации

**Текст сообщения:**
```
К сожалению, на вашем устройстве приложение пока не доступно. 
Вас может добавить к игре организатор.
```

---

## 📋 Итоговая рекомендация для бэкенда

### Минимальная реализация (для текущей версии):

1. **Определение iOS:** По User-Agent (`/iphone|ipad|ipod/`)
2. **Логика редиректа:** Вариант A (пробовать deep link, потом App Store)
3. **Сохранение кода:** Вариант B (localStorage)
4. **Поведение после возврата:** Автоматически пытаться открыть deep link
5. **Не-iOS устройства:** Показывать сообщение вместо кнопки App Store

### Полная реализация (для обеих версий):

1. **Universal Links:** Настроить файл `apple-app-site-association`
2. **Определение iOS:** По User-Agent
3. **Логика редиректа:** Universal Links + fallback на Custom URL Scheme
4. **Сохранение кода:** Universal Links решают автоматически + localStorage для обратной совместимости
5. **Поведение после возврата:** Universal Links автоматически + fallback на deep link
6. **Не-iOS устройства:** Показывать сообщение вместо кнопки App Store

---

## ✅ Чеклист для бэкенда

### Обязательно (для текущей версии):

- [ ] Определение iOS по User-Agent
- [ ] Логика: пробовать deep link → App Store (через 2-3 секунды)
- [ ] Сохранение кода в localStorage при редиректе в App Store
- [ ] Автоматическое открытие deep link после возврата из App Store
- [ ] Сообщение для не-iOS устройств вместо кнопки App Store
- [ ] Кнопка "Вернуться на главную" для не-iOS устройств

### Опционально (для будущей версии):

- [ ] Настроить файл `apple-app-site-association` (для Universal Links)
- [ ] Поддержка Universal Links + fallback на Custom URL Scheme

---

## 🔗 Связанные документы

- `universal-links-backend-checklist.md` - Детальный чеклист для бэкенда
- `universal-links-ios-setup.md` - Инструкция по настройке в iOS приложении
- `universal-links-deployment-strategy.md` - Стратегия развертывания
