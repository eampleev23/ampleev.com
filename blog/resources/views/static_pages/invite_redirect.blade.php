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
            background: #1A1B22;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .container {
            background: #1A1B22;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
            border: 1px solid #2A2B32;
        }
        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .logo svg {
            width: 80px;
            height: 80px;
        }
        h1 {
            color: #fff;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        p {
            color: #ccc;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .code {
            background: #2A2B32;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #512AFF;
            margin: 1rem 0;
            display: inline-block;
        }
        .button {
            background: #512AFF;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 1rem 0;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .button:hover {
            background: #4120CC;
        }
        .app-store-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #2A2B32;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <svg width="80" height="80" viewBox="0 0 190 190" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M34 168C34 175.732 27.2843 182 19 182C10.7157 182 4 175.732 4 168C4 160.268 10.7157 154 19 154C27.2843 154 34 160.268 34 168Z" fill="#FF7C2B"/>
            <path d="M61 148C61 155.732 54.2843 162 46 162C37.7157 162 31 155.732 31 148C31 140.268 37.7157 134 46 134C54.2843 134 61 140.268 61 148Z" fill="#59FF00"/>
            <path d="M189 138.5C189 145.956 183.18 152 176 152C168.82 152 163 145.956 163 138.5C163 131.044 168.82 125 176 125C183.18 125 189 131.044 189 138.5Z" fill="#59FF00"/>
            <path d="M181 16.5C181 24.5081 174.732 31 167 31C159.268 31 153 24.5081 153 16.5C153 8.49187 159.268 2 167 2C174.732 2 181 8.49187 181 16.5Z" fill="#59FF00"/>
            <path d="M104 61C104 69.2843 97.5081 76 89.5 76C81.4919 76 75 69.2843 75 61C75 52.7157 81.4919 46 89.5 46C97.5081 46 104 52.7157 104 61Z" fill="#59FF00"/>
            <path d="M37 125C37 132.732 30.5081 139 22.5 139C14.4919 139 8 132.732 8 125C8 117.268 14.4919 111 22.5 111C30.5081 111 37 117.268 37 125Z" fill="#512AFF"/>
            <path d="M67 162C67 169.732 60.732 176 53 176C45.268 176 39 169.732 39 162C39 154.268 45.268 148 53 148C60.732 148 67 154.268 67 162Z" fill="#512AFF"/>
            <path d="M163 56C163 63.732 156.06 70 147.5 70C138.94 70 132 63.732 132 56C132 48.268 138.94 42 147.5 42C156.06 42 163 48.268 163 56Z" fill="#512AFF"/>
            <path d="M107 84.5C107 92.5081 100.508 99 92.5 99C84.4919 99 78 92.5081 78 84.5C78 76.4919 84.4919 70 92.5 70C100.508 70 107 76.4919 107 84.5Z" fill="#512AFF"/>
            <path d="M37 164.5C37 172.508 30.9558 179 23.5 179C16.0442 179 10 172.508 10 164.5C10 156.492 16.0442 150 23.5 150C30.9558 150 37 156.492 37 164.5Z" fill="black"/>
            <path d="M99 164.5C99 172.508 92.732 179 85 179C77.268 179 71 172.508 71 164.5C71 156.492 77.268 150 85 150C92.732 150 99 156.492 99 164.5Z" fill="black"/>
            <path d="M153 91C153 98.732 146.508 105 138.5 105C130.492 105 124 98.732 124 91C124 83.268 130.492 77 138.5 77C146.508 77 153 83.268 153 91Z" fill="black"/>
            <path d="M41 14C41 21.732 34.0604 28 25.5 28C16.9396 28 10 21.732 10 14C10 6.26801 16.9396 0 25.5 0C34.0604 0 41 6.26801 41 14Z" fill="black"/>
            <path d="M31 148C31 155.732 24.5081 162 16.5 162C8.49187 162 2 155.732 2 148C2 140.268 8.49187 134 16.5 134C24.5081 134 31 140.268 31 148Z" fill="#FF006F"/>
            <path d="M41 70C41 77.732 34.0604 84 25.5 84C16.9396 84 10 77.732 10 70C10 62.268 16.9396 56 25.5 56C34.0604 56 41 62.268 41 70Z" fill="#FF006F"/>
            <path d="M84 148C84 155.732 77.5081 162 69.5 162C61.4919 162 55 155.732 55 148C55 140.268 61.4919 134 69.5 134C77.5081 134 84 140.268 84 148Z" fill="#FF006F"/>
            <path d="M132 30.5C132 38.5081 125.732 45 118 45C110.268 45 104 38.5081 104 30.5C104 22.4919 110.268 16 118 16C125.732 16 132 22.4919 132 30.5Z" fill="#FF006F"/>
            <path d="M65 123.5C65 132.06 58.5081 139 50.5 139C42.4919 139 36 132.06 36 123.5C36 114.94 42.4919 108 50.5 108C58.5081 108 65 114.94 65 123.5Z" fill="#FF7C2B"/>
            <path d="M73 170C73 177.732 66.5081 184 58.5 184C50.4919 184 44 177.732 44 170C44 162.268 50.4919 156 58.5 156C66.5081 156 73 162.268 73 170Z" fill="#FF7C2B"/>
            <path d="M124 62.5C124 70.5081 117.732 77 110 77C102.268 77 96 70.5081 96 62.5C96 54.4919 102.268 48 110 48C117.732 48 124 54.4919 124 62.5Z" fill="#FF7C2B"/>
        </svg>
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

