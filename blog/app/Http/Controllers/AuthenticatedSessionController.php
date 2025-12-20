<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Перенаправляем пользователя на Yandex OAuth
     */
    public function yandex()
    {
        // Сохраняем URL, с которого пришел пользователь, для возврата после авторизации
        if (request()->has('redirect_to')) {
            session(['auth_redirect' => request('redirect_to')]);
        } elseif (request()->headers->get('referer')) {
            session(['auth_redirect' => request()->headers->get('referer')]);
        }

        return Socialite::driver('yandex')->redirect();
    }

    /**
     * Обработка callback от Yandex OAuth
     */
    public function yandexRedirect()
    {
        try {
            $socialiteUser = Socialite::driver('yandex')->user();

            // Получаем имя пользователя
            $userName = $socialiteUser->name 
                ?? ($socialiteUser->user['display_name'] ?? null)
                ?? ($socialiteUser->user['first_name'] ?? 'Пользователь');

            // Создаем или находим пользователя
            $user = User::firstOrCreate(
                ['email' => $socialiteUser->email],
                [
                    'name' => $userName,
                    'password' => Hash::make(Str::random(24)),
                ]
            );

            // Авторизуем пользователя
            Auth::login($user, true);

            // Получаем URL для редиректа и проверяем наличие якоря до удаления из session
            $redirectUrl = session('auth_redirect', route('blog.home'));
            $hasAddCommentAnchor = strpos($redirectUrl, '#add_comment') !== false;
            session()->forget('auth_redirect');

            // Если в URL нет якоря #add_comment, но он был в redirect_to параметре, добавляем его
            if (!$hasAddCommentAnchor && request()->has('redirect_to')) {
                $redirectToParam = request('redirect_to');
                if (strpos($redirectToParam, '#add_comment') !== false) {
                    $redirectUrl .= '#add_comment';
                }
            }

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            // Логируем ошибку
            \Log::error('Yandex OAuth error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            // Перенаправляем обратно с сообщением об ошибке
            $redirectUrl = session('auth_redirect', route('blog.home'));
            session()->forget('auth_redirect');

            return redirect($redirectUrl)->with('error', 'Ошибка авторизации через Yandex. Попробуйте позже.');
        }
    }
}
