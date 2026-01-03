<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StaticController extends Controller
{
    public function about_me()
    {
        $active_menu_item = 'Обо мне';
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        return view('static_pages.about_me', compact('active_menu_item', 'last_articles'));
    }

    public function cv()
    {
        abort(404);
    }

    public function about_company()
    {
        $active_menu_item = 'О компании';
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        return view('static_pages.about_company', compact('active_menu_item', 'last_articles'));
    }

    public function contact()
    {
        $active_menu_item = 'Связаться';
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        return view('static_pages.contact', compact('active_menu_item', 'last_articles'));
    }

    public function pointscounter()
    {
        return view('static_pages.pointscounter');
    }

    public function contact_submit(Request $request)
    {
        // honeypot: если поле заполнено — считаем спамом
        if ($request->filled('contact_trap')) {
            return back()->withErrors(['form' => 'Не удалось отправить сообщение. Пожалуйста, попробуйте позже.'])->withInput();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string'],
            'recaptcha_token' => ['required', 'string'],
        ]);

        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        if (!$this->verifyRecaptcha($data['recaptcha_token'], $request->ip())) {
            return back()->withErrors(['form' => 'Не удалось подтвердить, что вы не робот. Попробуйте ещё раз.'])->withInput();
        }

        try {
            Mail::raw($this->buildMessage($data), function ($message) use ($data) {
                $message->to('support@mpleev.com')
                    ->subject('Новое сообщение с формы Связаться')
                    ->replyTo($data['email'], $data['name']);
            });
        } catch (\Throwable $e) {
            Log::error('Contact form send failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['form' => 'Не удалось отправить сообщение. Попробуйте ещё раз позже.'])->withInput();
        }

        return back()->with('contact_success', 'Спасибо! Мы свяжемся с вами в ближайшее время.');
    }

    private function buildMessage(array $data): string
    {
        return implode("\n", [
            "Новое сообщение с формы /contact",
            "Имя: {$data['name']}",
            "Email: {$data['email']}",
            'Компания: ' . ($data['company'] ?? '-'),
            'Телефон: ' . ($data['phone'] ?? '-'),
            '',
            'Сообщение:',
            $data['message'],
            '',
            'IP: ' . ($data['ip'] ?? '-'),
            'User-Agent: ' . ($data['user_agent'] ?? '-'),
        ]);
    }

    private function verifyRecaptcha(string $token, ?string $ip): bool
    {
        $secret = config('services.recaptcha.secret_key');
        if (!$secret) {
            Log::warning('reCAPTCHA secret key is not set');
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $ip,
            ]);
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA request failed', ['error' => $e->getMessage()]);
            return false;
        }

        if (!$response->ok()) {
            Log::error('reCAPTCHA non-200 response', ['status' => $response->status(), 'body' => $response->body()]);
            return false;
        }

        $payload = $response->json();
        if (empty($payload['success'])) {
            Log::warning('reCAPTCHA validation failed', ['payload' => $payload]);
            return false;
        }

        $score = $payload['score'] ?? 0;
        $threshold = config('services.recaptcha.score_threshold', 0.5);
        $action = $payload['action'] ?? null;

        if ($action !== null && $action !== 'contact') {
            Log::warning('reCAPTCHA unexpected action', ['action' => $action, 'score' => $score]);
            return false;
        }

        return $score >= $threshold;
    }
}
