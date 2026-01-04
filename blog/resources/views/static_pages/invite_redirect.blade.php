<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Присоединиться к игре - Points Counter</title>
    <meta http-equiv="refresh" content="0;url={{ $deepLink }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #ffffff;
            color: #000;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            border: 1px solid #000;
        }
        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .logo img {
            width: 80px;
            height: 80px;
            border: 1px solid #000;
            border-radius: 10px;
        }
        h1 {
            color: #000;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        p {
            color: #000;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .code {
            background: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #000;
            margin: 1rem 0;
            display: inline-block;
            border: 1px solid #000;
        }
        .button {
            background: #ffffff;
            color: #000;
            border: 1px solid #000;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 1rem 0;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s, color 0.3s;
        }
        .button:hover {
            background: #000;
            color: #ffffff;
        }
        .app-store-section {
            margin-top: 2rem;
            padding-top: 2rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="/assets/img/points_counter_1024_icon.png" alt="Points Counter">
    </div>

    <h1>Открываем игру...</h1>
    <p>Перенаправляем вас в приложение для присоединения к игре</p>

    <div>
        <p>Код приглашения:</p>
        <div class="code">{{ $code }}</div>
    </div>

    <div class="app-store-section" style="display: none;">
        <p>Приложение не установлено?</p>
        <a href="{{ $appStoreUrl }}" class="button">📲 Скачать Points Counter</a>
    </div>
</div>

<script>
    // Попытка редиректа на deep link
    window.location.href = "{{ $deepLink }}";
    
    // Если через 2 секунды приложение не открылось, показываем секцию App Store
    setTimeout(function() {
        document.querySelector('.app-store-section').style.display = 'block';
    }, 2000);
</script>
</body>
</html>

