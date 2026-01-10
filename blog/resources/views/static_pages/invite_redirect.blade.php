<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-itunes-app" content="app-id=6757125435">
    <title>Присоединиться к игре</title>
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
        .message {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            line-height: 1.6;
        }
        .instruction {
            display: none;
            font-size: 16px;
            margin: 20px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            max-width: 90%;
            text-align: center;
            line-height: 1.5;
        }
        .countdown {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
            text-align: center;
            display: none;
        }
        .app-store-button {
            display: none; /* Скрыта по умолчанию, показывается только как резервный вариант */
            padding: 15px 30px;
            background: #007AFF;
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .app-store-button:hover {
            background: #0051D5;
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
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="/assets/img/Icon-iOS-Dark-1024x1024@1x.png" alt="Points Counter">
    </div>

    <div class="code" id="invite-code">{{ $code }}</div>
    <div id="status-message" class="message"></div>
    <div id="instruction" class="instruction"></div>
    <div id="countdown" class="countdown"></div>
    <a id="app-store-button" href="https://apps.apple.com/app/id6757125435" class="app-store-button">
        Скачать Points Counter
    </a>

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
        DEEP_LINK_TIMEOUT: 2500, // 2.5 секунды для проверки установки
        APP_STORE_REDIRECT_DELAY: 5000, // 5 секунд до редиректа на App Store
        APP_STORE_URL: 'https://apps.apple.com/app/id6757125435',
        INSTRUCTION_TEXT: 'После установки приложения повторно отсканируйте QR-код или перейдите по ссылке-приглашению и все получится',
        STORAGE_KEY_CODE: 'pendingInviteCode',
        STORAGE_KEY_TIMESTAMP: 'pendingInviteTimestamp',
        STORAGE_EXPIRY: 3600000 // 1 час в миллисекундах
    };
    
    // Получаем invite-код из URL
    function getInviteCodeFromURL() {
        const path = window.location.pathname.trim().replace(/^\//, '').replace(/\/$/, '');
        
        // Проверяем, что путь соответствует формату invite-кода (6-10 символов, A-Z0-9)
        if (path.length >= 6 && path.length <= 10 && /^[A-Z0-9]+$/i.test(path)) {
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
    function tryOpenDeepLink(inviteCode) {
        const deepLink = `pointscounter://activity/join/${inviteCode}`;
        console.log('[Invite Page] Trying to open deep link:', deepLink);
        window.location.href = deepLink;
    }
    
    // Сохраняем invite-код в localStorage
    function saveCodeToStorage(inviteCode) {
        try {
            localStorage.setItem(CONFIG.STORAGE_KEY_CODE, inviteCode);
            localStorage.setItem(CONFIG.STORAGE_KEY_TIMESTAMP, Date.now().toString());
            console.log('[Invite Page] Saved invite code to localStorage:', inviteCode);
        } catch (e) {
            console.error('[Invite Page] Failed to save to localStorage:', e);
        }
    }
    
    // Удаляем invite-код из localStorage
    function removeCodeFromStorage() {
        try {
            localStorage.removeItem(CONFIG.STORAGE_KEY_CODE);
            localStorage.removeItem(CONFIG.STORAGE_KEY_TIMESTAMP);
            console.log('[Invite Page] Removed invite code from localStorage');
        } catch (e) {
            console.error('[Invite Page] Failed to remove from localStorage:', e);
        }
    }
    
    // Редиректим на App Store
    function redirectToAppStore() {
        console.log('[Invite Page] Redirecting to App Store...');
        window.location.href = CONFIG.APP_STORE_URL;
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
            instructionEl.textContent = CONFIG.INSTRUCTION_TEXT;
            instructionEl.style.display = 'block';
        }
    }
    
    // Показываем счетчик обратного отсчета
    function showCountdown(seconds, callback) {
        const countdownEl = document.getElementById('countdown');
        if (!countdownEl) return;
        
        countdownEl.style.display = 'block';
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
            inviteCodeEl.textContent = inviteCode;
        }
        
        // Если это не iOS устройство
        if (!isIOS()) {
            document.getElementById('non-ios-section').classList.remove('hidden');
            return;
        }
        
        // Если invite-код не найден, проверяем localStorage
        if (!inviteCode) {
            try {
                const savedCode = localStorage.getItem(CONFIG.STORAGE_KEY_CODE);
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
            }, CONFIG.DEEP_LINK_TIMEOUT);
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
})();
</script>
</body>
</html>
