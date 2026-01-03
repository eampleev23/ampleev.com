<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Перенаправляем пользователя на Yandex OAuth
     */
    public function yandex()
    {
        \Log::info('AuthenticatedSessionController::yandex() called');
        
        // Сохраняем URL, с которого пришел пользователь, для возврата после авторизации
        if (request()->has('redirect_to')) {
            session(['auth_redirect' => request('redirect_to')]);
        } elseif (request()->headers->get('referer')) {
            session(['auth_redirect' => request()->headers->get('referer')]);
        }

        \Log::info('Attempting to use Socialite::driver("yandex")');
        
        try {
            $driver = Socialite::driver('yandex');
            \Log::info('Socialite::driver("yandex") created successfully');
            return $driver->redirect();
        } catch (\Exception $e) {
            \Log::error('Error in Socialite::driver("yandex"): ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
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

            // Получаем аватарку из Yandex
            $avatarUrl = null;
            if ($socialiteUser->avatar) {
                try {
                    $yandexId = $socialiteUser->getId();
                    $fileContents = file_get_contents($socialiteUser->avatar);
                    Storage::put('public/user_avatars/' . $yandexId . '.jpg', $fileContents);
                    $avatarUrl = Storage::url('public/user_avatars/' . $yandexId . '.jpg');
                } catch (\Exception $e) {
                    \Log::warning('Failed to save Yandex avatar: ' . $e->getMessage());
                }
            }

            // Создаем или находим пользователя
            $user = User::firstOrCreate(
                ['email' => $socialiteUser->email],
                [
                    'name' => $userName,
                    'password' => Hash::make(Str::random(24)),
                    'avatar_path' => $avatarUrl ?? '/storage/user_avatars/default.jpg',
                ]
            );

            // Обновляем аватарку, если она была получена и у пользователя её нет
            if ($avatarUrl && !$user->avatar_path) {
                $user->avatar_path = $avatarUrl;
                $user->save();
            }

            // Авторизуем пользователя
            Auth::login($user, true);

            // Получаем URL для редиректа и проверяем наличие якоря до удаления из session
            $redirectUrl = session('auth_redirect', route('static_pages.home'));
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
            $redirectUrl = session('auth_redirect', route('static_pages.home'));
            session()->forget('auth_redirect');

            return redirect($redirectUrl)->with('error', 'Ошибка авторизации через Yandex. Попробуйте позже.');
        }
    }
}
