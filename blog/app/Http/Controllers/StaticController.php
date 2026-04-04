<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use App\Support\SiteLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StaticController extends Controller
{
    private function currentLocale(): string
    {
        return SiteLocale::resolve(request());
    }

    private function localizeArticles($articles, ?string $locale = null)
    {
        $locale = $locale ?? $this->currentLocale();

        if ($locale === SiteLocale::EN) {
            $articles->each->applyLocale(SiteLocale::EN);
        }

        return $articles;
    }

    public function about_me()
    {
        $locale = $this->currentLocale();
        $active_menu_item = 'Обо мне';
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        $this->localizeArticles($last_articles, $locale);
        return view('static_pages.about_me', compact('active_menu_item', 'last_articles'));
    }

    public function cv()
    {
        abort(404);
    }

    public function about_company()
    {
        $locale = $this->currentLocale();
        $active_menu_item = 'О компании';
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        $this->localizeArticles($last_articles, $locale);
        return view('static_pages.about_company', compact('active_menu_item', 'last_articles'));
    }

    public function contact()
    {
        $locale = $this->currentLocale();
        $active_menu_item = 'Контакты';
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();
        $this->localizeArticles($last_articles, $locale);

        return view('static_pages.contact', compact('active_menu_item', 'last_articles'));
    }

    public function contact_submit(Request $request)
    {
        $locale = SiteLocale::resolve($request);
        $botErrorMessage = $locale === SiteLocale::EN
            ? 'We could not send your message. Please try again later.'
            : 'Не удалось отправить сообщение. Пожалуйста, попробуйте позже.';

        // honeypot: если поле заполнено — считаем спамом
        if ($request->filled('contact_trap')) {
            return back()->withErrors(['form' => $botErrorMessage])->withInput();
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
            return back()->withErrors(['form' => $locale === SiteLocale::EN
                ? 'We could not verify that you are not a robot. Please try again.'
                : 'Не удалось подтвердить, что вы не робот. Попробуйте ещё раз.'])->withInput();
        }

        try {
            $contactEmail = env('MAIL_CONTACT_TO', 'support@mpleev.com');
            Mail::raw($this->buildMessage($data), function ($message) use ($data, $contactEmail) {
                $message->to($contactEmail)
                    ->subject('Новое сообщение с формы Контакты')
                    ->replyTo($data['email'], $data['name']);
            });
        } catch (\Throwable $e) {
            Log::error('Contact form send failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['form' => $locale === SiteLocale::EN
                ? 'We could not send your message. Please try again later.'
                : 'Не удалось отправить сообщение. Попробуйте ещё раз позже.'])->withInput();
        }

        return back()->with('contact_success', $locale === SiteLocale::EN
            ? 'Thank you! We will get back to you soon.'
            : 'Спасибо! Мы свяжемся с вами в ближайшее время.');
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
