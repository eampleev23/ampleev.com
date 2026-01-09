<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Открываем игру... - Points Counter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .container {
            background: #000;
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .logo img {
            width: 120px;
            height: 120px;
            border-radius: 20px;
        }
        h1 {
            color: #fff;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }
        p {
            color: #fff;
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 16px;
        }
        .code {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #fff;
            margin: 1.5rem 0;
            display: inline-block;
            font-size: 24px;
            letter-spacing: 4px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .button {
            background: #007AFF;
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 1rem 0;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .button:hover {
            background: #0051D5;
        }
        .button:active {
            background: #003D99;
        }
        .hidden {
            display: none;
        }
        .message {
            margin: 1rem 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="/assets/img/Icon-iOS-Dark-1024x1024@1x.png" alt="Points Counter">
    </div>

    <h1>Открываем игру...</h1>
    
    <div class="code" id="invite-code">{{ $code }}</div>

    <!-- Для iOS устройств -->
    <div id="ios-section" class="hidden">
        <p class="message">Перенаправляем вас в приложение для присоединения к игре</p>
        <a href="#" id="app-store-button" class="button hidden">
            📲 Скачать Points Counter
        </a>
    </div>

    <!-- Для не-iOS устройств -->
    <div id="non-ios-section" class="hidden">
        <p class="message">
            К сожалению, на вашем устройстве приложение пока не доступно. 
            Вас может добавить к игре организатор.
        </p>
        <a href="/" class="button">Вернуться на главную</a>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    // Конфигурация
    const CONFIG = {
        DEEP_LINK_TIMEOUT: 2500, // 2.5 секунды
        APP_STORE_URL: 'https://apps.apple.com/app/id6757125435',
        STORAGE_KEY_CODE: 'pendingInviteCode',
        STORAGE_KEY_TIMESTAMP: 'pendingInviteTimestamp',
        STORAGE_EXPIRY: 3600000 // 1 час в миллисекундах
    };
    
    // Получаем invite-код из URL
    function getInviteCodeFromURL() {
        const path = window.location.pathname.trim().replace(/^\//, '').replace(/\/$/, '');
        
        // Проверяем, что путь соответствует формату invite-кода (6-10 символов, A-Z0-9)
        if (path.length >= 6 && path.length <= 10 && /^[A-Z0-9]+$/.test(path.toUpperCase())) {
            return path.toUpperCase();
        }
        
        return null;
    }
    
    // Проверяем, iOS ли это
    function isIOS() {
        const userAgent = window.navigator.userAgent.toLowerCase();
        return /iphone|ipad|ipod/.test(userAgent) || 
               (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    }
    
    // Пытаемся открыть deep link
    function tryOpenDeepLink(code) {
        const deepLink = `pointscounter://activity/join/${code}`;
        console.log('Trying to open deep link:', deepLink);
        
        // Пытаемся открыть deep link
        window.location.href = deepLink;
        
        // Устанавливаем таймаут для показа кнопки App Store
        setTimeout(() => {
            showAppStoreButton(code);
        }, CONFIG.DEEP_LINK_TIMEOUT);
    }
    
    // Показываем кнопку App Store
    function showAppStoreButton(code) {
        const button = document.getElementById('app-store-button');
        if (button) {
            // Сохраняем код в localStorage перед редиректом
            saveCodeToStorage(code);
            
            // Устанавливаем URL кнопки
            button.href = CONFIG.APP_STORE_URL;
            
            // Показываем кнопку
            button.classList.remove('hidden');
        }
    }
    
    // Сохраняем код в localStorage
    function saveCodeToStorage(code) {
        try {
            localStorage.setItem(CONFIG.STORAGE_KEY_CODE, code);
            localStorage.setItem(CONFIG.STORAGE_KEY_TIMESTAMP, Date.now().toString());
        } catch (e) {
            console.error('Failed to save to localStorage:', e);
        }
    }
    
    // Получаем сохраненный код из localStorage
    function getSavedCodeFromStorage() {
        try {
            const code = localStorage.getItem(CONFIG.STORAGE_KEY_CODE);
            const timestamp = localStorage.getItem(CONFIG.STORAGE_KEY_TIMESTAMP);
            
            if (!code || !timestamp) {
                return null;
            }
            
            // Проверяем, что код не старше 1 часа
            const age = Date.now() - parseInt(timestamp, 10);
            if (age > CONFIG.STORAGE_EXPIRY) {
                // Код устарел, удаляем
                localStorage.removeItem(CONFIG.STORAGE_KEY_CODE);
                localStorage.removeItem(CONFIG.STORAGE_KEY_TIMESTAMP);
                return null;
            }
            
            return code;
        } catch (e) {
            console.error('Failed to read from localStorage:', e);
            return null;
        }
    }
    
    // Очищаем сохраненный код из localStorage
    function clearSavedCodeFromStorage() {
        try {
            localStorage.removeItem(CONFIG.STORAGE_KEY_CODE);
            localStorage.removeItem(CONFIG.STORAGE_KEY_TIMESTAMP);
        } catch (e) {
            console.error('Failed to clear localStorage:', e);
        }
    }
    
    // Обработка возврата из App Store
    function handleReturnFromAppStore() {
        const codeFromURL = getInviteCodeFromURL();
        
        // Если код есть в URL - используем его
        if (codeFromURL) {
            // Очищаем localStorage, так как код уже в URL
            clearSavedCodeFromStorage();
            
            // Пытаемся открыть deep link
            tryOpenDeepLink(codeFromURL);
            return;
        }
        
        // Если кода нет в URL - проверяем localStorage
        const savedCode = getSavedCodeFromStorage();
        if (savedCode) {
            // Пытаемся открыть deep link
            tryOpenDeepLink(savedCode);
        }
    }
    
    // Инициализация
    function init() {
        const code = getInviteCodeFromURL();
        
        // Устанавливаем код в интерфейс
        const codeElement = document.getElementById('invite-code');
        if (codeElement && code) {
            codeElement.textContent = code;
        }
        
        // Проверяем тип устройства
        if (isIOS()) {
            // iOS устройство
            document.getElementById('ios-section').classList.remove('hidden');
            
            // Обрабатываем возврат из App Store или пытаемся открыть deep link
            handleReturnFromAppStore();
        } else {
            // Не-iOS устройство - показываем сообщение сразу
            document.getElementById('non-ios-section').classList.remove('hidden');
        }
    }
    
    // Запускаем при загрузке страницы
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
</body>
</html>
