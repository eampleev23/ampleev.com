# Спецификация для бэкенда: Universal Links и HTML страница приглашения

**Дата:** 2026-01-09  
**Версия:** 1.0  
**Приоритет:** Высокий  
**Статус:** Требуется проверка и реализация

---

## 📋 Содержание

1. [Требования](#требования)
2. [Проверка текущей реализации](#проверка-текущей-реализации)
3. [Инструкции по корректировке](#инструкции-по-корректировке)
4. [Техническая реализация](#техническая-реализация)
5. [Тестирование](#тестирование)

---

## 🎯 Требования

### 1. Smart App Banner (ОБЯЗАТЕЛЬНО)

**Что это:**
- Специальный баннер iOS, который показывается вверху страницы Safari
- Позволяет открыть приложение одним нажатием после установки
- Universal Link передается автоматически

**Требование:**
Добавить в `<head>` HTML страницы:
```html
<meta name="apple-itunes-app" content="app-id=6757125435">
```

**Проверка:**
- [ ] Мета-тег присутствует в `<head>`
- [ ] App ID правильный: `6757125435`
- [ ] Баннер показывается в Safari после установки приложения

---

### 2. Автоматический редирект на App Store

**Требование:**
Если приложение не установлено, автоматически редиректить на App Store через 5 секунд.

**Логика:**
1. При загрузке страницы определяем, что приложение не установлено
2. Показываем сообщение: **"Приложение не установлено"**
3. Показываем инструкцию (см. раздел 3)
4. Показываем счетчик: **"Перенаправляем в App Store через 5... 4... 3... 2... 1..."**
5. Через **5 секунд** автоматически редиректим на App Store
6. **Важно:** Пользователь НЕ должен нажимать кнопку - редирект автоматический
7. **Важно:** Приложение НЕ скачивается автоматически - пользователь сам нажимает "Установить"

**Проверка:**
- [ ] Редирект происходит автоматически (без кнопки)
- [ ] Задержка составляет 5 секунд
- [ ] Счетчик показывает обратный отсчет от 5 до 1
- [ ] URL редиректа: `https://apps.apple.com/app/id6757125435`

---

### 3. Инструкция для пользователя

**Требование:**
Показывать понятную инструкцию перед редиректом на App Store.

**Текст инструкции:**
```
"После установки приложения повторно отсканируйте QR-код или перейдите по ссылке-приглашению и все получится"
```

**Визуальное оформление:**
- Инструкция должна быть в отдельном выделенном блоке
- Полупрозрачный белый фон: `rgba(255,255,255,0.1)`
- Закругленные углы: `border-radius: 8px`
- Крупный шрифт: `font-size: 16px`
- Заметное расположение на странице

**Проверка:**
- [ ] Инструкция показывается перед редиректом
- [ ] Текст соответствует требованиям
- [ ] Визуальное оформление соответствует требованиям
- [ ] Инструкция видна и понятна пользователю

---

### 4. Сохранение invite-кода в localStorage

**Требование:**
Сохранять invite-код в `localStorage` при загрузке страницы.

**Логика:**
- При загрузке страницы сохраняем invite-код в `localStorage.setItem('pendingInviteCode', inviteCode)`
- **Основной механизм:** Smart App Banner + Universal Links (работает автоматически)
- **Резервный механизм:** Если Smart App Banner не сработал, можно использовать `localStorage`
- После успешного открытия → удаляем код из `localStorage`

**Проверка:**
- [ ] Invite-код сохраняется в `localStorage` при загрузке страницы
- [ ] Ключ: `pendingInviteCode`
- [ ] Значение: invite-код из URL

---

### 5. Обработка установленного приложения

**Требование:**
Если приложение установлено, пытаться открыть его через deep link.

**Логика:**
1. При загрузке страницы пытаемся открыть deep link: `pointscounter://activity/join/{inviteCode}`
2. Показываем сообщение: "Открываем приложение..."
3. Если через 2.5 секунды приложение не открылось → показываем инструкцию и редирект на App Store

**Проверка:**
- [ ] Пытаемся открыть deep link при загрузке страницы
- [ ] Формат deep link: `pointscounter://activity/join/{inviteCode}`
- [ ] Таймаут: 2.5 секунды
- [ ] Если не открылось → показываем инструкцию и редирект

---

## 🔍 Проверка текущей реализации

### Чеклист проверки

#### 1. Smart App Banner
- [ ] Проверить наличие `<meta name="apple-itunes-app" content="app-id=6757125435">` в `<head>`
- [ ] Проверить, что App ID правильный: `6757125435`
- [ ] Протестировать на iOS устройстве после установки приложения

**Как проверить:**
1. Открыть HTML страницу в Safari на iOS
2. Установить приложение из App Store
3. Вернуться на страницу
4. Должен показаться Smart App Banner вверху страницы

#### 2. Автоматический редирект
- [ ] Проверить, что редирект происходит автоматически (без кнопки)
- [ ] Проверить задержку (должна быть 5 секунд)
- [ ] Проверить наличие счетчика обратного отсчета
- [ ] Проверить URL редиректа: `https://apps.apple.com/app/id6757125435`

**Как проверить:**
1. Открыть HTML страницу на iOS устройстве без установленного приложения
2. Должно показаться сообщение "Приложение не установлено"
3. Должен показаться счетчик "Перенаправляем в App Store через 5... 4... 3... 2... 1..."
4. Через 5 секунд должен произойти автоматический редирект в App Store

#### 3. Инструкция
- [ ] Проверить наличие инструкции на странице
- [ ] Проверить текст инструкции (должен соответствовать требованиям)
- [ ] Проверить визуальное оформление инструкции

**Как проверить:**
1. Открыть HTML страницу на iOS устройстве без установленного приложения
2. Должна показаться инструкция: "После установки приложения повторно отсканируйте QR-код или перейдите по ссылке-приглашению и все получится"
3. Инструкция должна быть в выделенном блоке с полупрозрачным фоном

#### 4. localStorage
- [ ] Проверить, что invite-код сохраняется в `localStorage`
- [ ] Проверить ключ: `pendingInviteCode`
- [ ] Проверить значение (должен быть invite-код из URL)

**Как проверить:**
1. Открыть HTML страницу в Safari на iOS
2. Открыть консоль разработчика (Safari → Develop → [Устройство] → [Страница])
3. Выполнить: `localStorage.getItem('pendingInviteCode')`
4. Должен вернуться invite-код из URL

#### 5. Deep link
- [ ] Проверить, что при загрузке страницы пытаемся открыть deep link
- [ ] Проверить формат: `pointscounter://activity/join/{inviteCode}`
- [ ] Проверить таймаут: 2.5 секунды

**Как проверить:**
1. Установить приложение на iOS устройство
2. Открыть HTML страницу
3. Должно показаться сообщение "Открываем приложение..."
4. Приложение должно открыться автоматически

---

## 🔧 Инструкции по корректировке

### Если Smart App Banner отсутствует

**Проблема:** Баннер не показывается после установки приложения

**Решение:**
1. Добавить в `<head>` HTML страницы:
   ```html
   <meta name="apple-itunes-app" content="app-id=6757125435">
   ```
2. Убедиться, что App ID правильный: `6757125435`
3. Проверить, что страница открыта в Safari (не в других браузерах)

---

### Если редирект не происходит автоматически

**Проблема:** Пользователь должен вручную нажимать кнопку для перехода в App Store

**Решение:**
1. Убрать кнопку "Скачать Points Counter" (или скрыть её)
2. Добавить автоматический редирект через JavaScript:
   ```javascript
   setTimeout(() => {
       window.location.href = 'https://apps.apple.com/app/id6757125435';
   }, 5000);
   ```
3. Убедиться, что задержка составляет 5 секунд
4. Добавить счетчик обратного отсчета

---

### Если инструкция отсутствует или неправильная

**Проблема:** Пользователь не знает, что делать после установки приложения

**Решение:**
1. Добавить блок с инструкцией на страницу
2. Текст инструкции: "После установки приложения повторно отсканируйте QR-код или перейдите по ссылке-приглашению и все получится"
3. Визуальное оформление:
   ```css
   .instruction {
       display: block;
       font-size: 16px;
       margin: 20px 0;
       padding: 15px;
       background: rgba(255,255,255,0.1);
       border-radius: 8px;
       max-width: 90%;
   }
   ```
4. Показывать инструкцию перед редиректом на App Store

---

### Если invite-код не сохраняется в localStorage

**Проблема:** Invite-код теряется после установки приложения

**Решение:**
1. Добавить сохранение invite-кода при загрузке страницы:
   ```javascript
   const inviteCode = getInviteCodeFromURL();
   if (inviteCode) {
       localStorage.setItem('pendingInviteCode', inviteCode);
   }
   ```
2. Проверить, что функция `getInviteCodeFromURL()` правильно извлекает код из URL
3. Проверить, что `localStorage` доступен (не в приватном режиме)

---

### Если deep link не открывается

**Проблема:** При установленном приложении не происходит автоматическое открытие

**Решение:**
1. Проверить формат deep link: `pointscounter://activity/join/{inviteCode}`
2. Убедиться, что приложение установлено
3. Проверить, что Custom URL Scheme настроен в приложении
4. Добавить попытку открытия deep link при загрузке страницы:
   ```javascript
   if (inviteCode) {
       window.location.href = `pointscounter://activity/join/${inviteCode}`;
   }
   ```

---

## 💻 Техническая реализация

### Полный HTML код

```html
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-itunes-app" content="app-id=6757125435">
    <title>Присоединиться к игре</title>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .message {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
        }
        
        .instruction {
            display: none;
            font-size: 16px;
            margin: 20px 0;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            max-width: 90%;
            text-align: center;
        }
        
        .countdown {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
            text-align: center;
        }
        
        .app-store-button {
            display: none;
            padding: 15px 30px;
            background: #fff;
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
        }
        
        .app-store-button:hover {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <div id="invite-code" class="message"></div>
    <div id="status-message" class="message"></div>
    <div id="instruction" class="instruction"></div>
    <div id="countdown" class="countdown"></div>
    <a id="app-store-button" href="https://apps.apple.com/app/id6757125435" class="app-store-button">
        Скачать Points Counter
    </a>
    
    <script>
        // Конфигурация
        const DEEP_LINK_TIMEOUT = 2500; // 2.5 секунды для проверки установки
        const APP_STORE_REDIRECT_DELAY = 5000; // 5 секунд до редиректа на App Store
        const APP_STORE_URL = 'https://apps.apple.com/app/id6757125435';
        const INSTRUCTION_TEXT = 'После установки приложения повторно отсканируйте QR-код или перейдите по ссылке-приглашению и все получится';
        
        // Получаем invite-код из URL
        function getInviteCodeFromURL() {
            const path = window.location.pathname;
            const code = path.replace(/^\//, '').replace(/\/$/, '');
            // Проверяем формат (6-10 символов, A-Z0-9)
            if (code.length >= 6 && code.length <= 10 && /^[A-Z0-9]+$/i.test(code)) {
                return code.toUpperCase();
            }
            return null;
        }
        
        // Проверяем, является ли устройство iOS
        function isIOS() {
            return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        }
        
        // Пытаемся открыть deep link
        function tryOpenDeepLink(inviteCode) {
            const deepLink = `pointscounter://activity/join/${inviteCode}`;
            console.log('[Invite Page] Trying to open deep link:', deepLink);
            window.location.href = deepLink;
        }
        
        // Сохраняем invite-код в localStorage
        function saveCodeToStorage(inviteCode) {
            try {
                localStorage.setItem('pendingInviteCode', inviteCode);
                console.log('[Invite Page] Saved invite code to localStorage:', inviteCode);
            } catch (e) {
                console.error('[Invite Page] Failed to save to localStorage:', e);
            }
        }
        
        // Удаляем invite-код из localStorage
        function removeCodeFromStorage() {
            try {
                localStorage.removeItem('pendingInviteCode');
                console.log('[Invite Page] Removed invite code from localStorage');
            } catch (e) {
                console.error('[Invite Page] Failed to remove from localStorage:', e);
            }
        }
        
        // Редиректим на App Store
        function redirectToAppStore() {
            console.log('[Invite Page] Redirecting to App Store...');
            window.location.href = APP_STORE_URL;
        }
        
        // Показываем сообщение
        function showMessage(text) {
            const messageEl = document.getElementById('status-message');
            if (messageEl) {
                messageEl.textContent = text;
            }
        }
        
        // Показываем инструкцию
        function showInstruction() {
            const instructionEl = document.getElementById('instruction');
            if (instructionEl) {
                instructionEl.textContent = INSTRUCTION_TEXT;
                instructionEl.style.display = 'block';
            }
        }
        
        // Показываем счетчик обратного отсчета
        function showCountdown(seconds, callback) {
            const countdownEl = document.getElementById('countdown');
            if (!countdownEl) return;
            
            let remaining = seconds;
            
            const updateCountdown = () => {
                if (remaining > 0) {
                    countdownEl.textContent = `Перенаправляем в App Store через ${remaining}...`;
                    remaining--;
                    setTimeout(updateCountdown, 1000);
                } else {
                    countdownEl.textContent = '';
                    if (callback) callback();
                }
            };
            
            updateCountdown();
        }
        
        // Основная логика
        function init() {
            const inviteCode = getInviteCodeFromURL();
            const inviteCodeEl = document.getElementById('invite-code');
            
            // Показываем invite-код
            if (inviteCodeEl && inviteCode) {
                inviteCodeEl.textContent = `Код приглашения: ${inviteCode}`;
            }
            
            // Если это не iOS устройство
            if (!isIOS()) {
                showMessage('К сожалению, на вашем устройстве приложение пока не доступно');
                return;
            }
            
            // Если invite-код не найден, проверяем localStorage
            if (!inviteCode) {
                try {
                    const savedCode = localStorage.getItem('pendingInviteCode');
                    if (savedCode) {
                        tryOpenDeepLink(savedCode);
                        removeCodeFromStorage();
                        showMessage('Открываем приложение...');
                        return;
                    }
                } catch (e) {
                    console.error('[Invite Page] Failed to read localStorage:', e);
                }
            }
            
            // Если invite-код есть, сохраняем его
            if (inviteCode) {
                saveCodeToStorage(inviteCode);
            }
            
            // Пытаемся открыть deep link (если приложение установлено)
            if (inviteCode) {
                showMessage('Открываем приложение...');
                tryOpenDeepLink(inviteCode);
                
                // Если через DEEP_LINK_TIMEOUT приложение не открылось, показываем инструкцию и редирект
                setTimeout(() => {
                    showMessage('Приложение не установлено');
                    showInstruction();
                    showCountdown(5, () => {
                        showMessage('Перенаправляем в App Store...');
                        setTimeout(() => {
                            redirectToAppStore();
                        }, 500);
                    });
                }, DEEP_LINK_TIMEOUT);
            } else {
                // Если invite-кода нет, просто показываем инструкцию и редирект
                showMessage('Приложение не установлено');
                showInstruction();
                showCountdown(5, () => {
                    showMessage('Перенаправляем в App Store...');
                    setTimeout(() => {
                        redirectToAppStore();
                    }, 500);
                });
            }
        }
        
        // Запускаем при загрузке страницы
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    </script>
</body>
</html>
```

---

## 🧪 Тестирование

### Тест 1: Приложение установлено

**Шаги:**
1. Установить приложение на iOS устройство
2. Открыть ссылку: `https://pointscounter.ampleev.com/DY8TCY`
3. Проверить результат

**Ожидаемый результат:**
- Приложение открывается автоматически (Universal Links)
- ИЛИ показывается сообщение "Открываем приложение..." и приложение открывается через deep link
- Пользователь присоединяется к игре автоматически

---

### Тест 2: Приложение не установлено

**Шаги:**
1. Удалить приложение с iOS устройства
2. Открыть ссылку: `https://pointscounter.ampleev.com/DY8TCY`
3. Проверить результат

**Ожидаемый результат:**
- Показывается сообщение "Приложение не установлено"
- Показывается инструкция: "После установки приложения повторно отсканируйте QR-код или перейдите по ссылке-приглашению и все получится"
- Показывается счетчик: "Перенаправляем в App Store через 5... 4... 3... 2... 1..."
- Через 5 секунд автоматически открывается App Store

---

### Тест 3: После установки

**Шаги:**
1. Удалить приложение с iOS устройства
2. Открыть ссылку: `https://pointscounter.ampleev.com/DY8TCY`
3. Установить приложение из App Store
4. Повторно открыть ссылку или отсканировать QR-код
5. Проверить результат

**Ожидаемый результат:**
- Показывается Smart App Banner вверху страницы (если открыто в Safari)
- Приложение открывается автоматически с Universal Link
- Пользователь присоединяется к игре автоматически

---

### Тест 4: localStorage

**Шаги:**
1. Открыть ссылку: `https://pointscounter.ampleev.com/DY8TCY` на iOS устройстве
2. Открыть консоль разработчика
3. Проверить `localStorage.getItem('pendingInviteCode')`

**Ожидаемый результат:**
- В `localStorage` сохранен invite-код из URL
- Ключ: `pendingInviteCode`
- Значение: invite-код (например, `DY8TCY`)

---

## 📊 Итоговый чеклист

### Обязательные требования
- [ ] Smart App Banner добавлен (`<meta name="apple-itunes-app" content="app-id=6757125435">`)
- [ ] Автоматический редирект на App Store (5 секунд)
- [ ] Инструкция показывается перед редиректом
- [ ] Текст инструкции соответствует требованиям
- [ ] Invite-код сохраняется в `localStorage`
- [ ] Deep link открывается при установленном приложении

### Проверка текущей реализации
- [ ] Проверено наличие Smart App Banner
- [ ] Проверен автоматический редирект
- [ ] Проверена инструкция
- [ ] Проверено сохранение в `localStorage`
- [ ] Проверено открытие deep link

### Тестирование
- [ ] Протестировано с установленным приложением
- [ ] Протестировано без установленного приложения
- [ ] Протестировано после установки
- [ ] Протестировано на разных iOS версиях

---

## 🔗 Связанные документы

- `universal-links-ios-setup.md` - Настройка Universal Links в iOS (уже реализовано)
- `universal-links-testing-guide.md` - Инструкция по тестированию
- `apple-app-site-association.json` - Файл конфигурации для бэкенда (уже настроен)

---

## 📝 Примечания

1. **iOS сторона уже готова** - все изменения в iOS приложении уже реализованы и опубликованы в App Store
2. **Файл `apple-app-site-association` уже настроен** - проверьте доступность по адресу `https://pointscounter.ampleev.com/.well-known/apple-app-site-association`
3. **Основная задача** - обновить HTML страницу приглашения согласно требованиям

---

## ✅ Критерии готовности

Страница считается готовой, если:
- ✅ Smart App Banner показывается после установки приложения
- ✅ Автоматический редирект на App Store работает (5 секунд)
- ✅ Инструкция показывается и понятна пользователю
- ✅ Invite-код сохраняется в `localStorage`
- ✅ Все тесты проходят успешно
