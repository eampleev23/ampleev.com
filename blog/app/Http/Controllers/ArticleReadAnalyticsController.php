<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleReadSession;
use App\Support\SiteLocale;
use App\ViewArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class ArticleReadAnalyticsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|integer|exists:articles,id',
            'session_key' => 'required|string|max:80',
            'max_scroll_percent' => 'required|integer|min:0|max:100',
            'active_seconds' => 'nullable|integer|min:0|max:86400',
            'reached_25' => 'nullable|boolean',
            'reached_50' => 'nullable|boolean',
            'reached_75' => 'nullable|boolean',
            'reached_100' => 'nullable|boolean',
            'viewport_width' => 'nullable|integer|min:0|max:10000',
            'viewport_height' => 'nullable|integer|min:0|max:10000',
            'screen_width' => 'nullable|integer|min:0|max:10000',
            'screen_height' => 'nullable|integer|min:0|max:10000',
            'url' => 'nullable|string|max:2000',
            'referer' => 'nullable|string|max:2000',
        ]);

        $article = Article::where('id', $validated['article_id'])
            ->where('confirmed', 1)
            ->firstOrFail();

        $ip = $request->ip();
        $userId = Auth::id();
        $locale = SiteLocale::resolve($request);
        $userAgent = (string) $request->userAgent();
        $referer = (string) ($validated['referer'] ?? $request->headers->get('referer'));
        $url = (string) ($validated['url'] ?? '');

        $session = DB::transaction(function () use ($article, $validated, $ip, $userId, $locale, $userAgent, $referer, $url) {
            $session = ArticleReadSession::where('session_key', $validated['session_key'])
                ->lockForUpdate()
                ->first();

            if (!$session) {
                $session = new ArticleReadSession();
                $session->article_id = $article->id;
                $session->session_key = $validated['session_key'];
                $session->ip = $ip;
                $session->user_agent = $userAgent;
                $session->locale = $locale;
                $session->device_type = $this->detectDeviceType($userAgent);
                $session->source_type = $this->classifySource($referer, $url);
                $session->referer = $referer;
                $session->first_url = $url;
                $session->started_at = now();
            }

            $session->user_id = $session->user_id ?: $userId;
            $session->view_article_id = $session->view_article_id ?: $this->resolveViewArticleId($article->id, $ip, $userId);
            $session->last_url = $url ?: $session->last_url;
            $session->max_scroll_percent = max((int) $session->max_scroll_percent, (int) $validated['max_scroll_percent']);
            $session->active_seconds = max((int) $session->active_seconds, (int) ($validated['active_seconds'] ?? 0));
            $session->reached_25 = (bool) $session->reached_25 || (bool) ($validated['reached_25'] ?? false);
            $session->reached_50 = (bool) $session->reached_50 || (bool) ($validated['reached_50'] ?? false);
            $session->reached_75 = (bool) $session->reached_75 || (bool) ($validated['reached_75'] ?? false);
            $session->reached_100 = (bool) $session->reached_100 || (bool) ($validated['reached_100'] ?? false);
            $session->viewport_width = $validated['viewport_width'] ?? $session->viewport_width;
            $session->viewport_height = $validated['viewport_height'] ?? $session->viewport_height;
            $session->screen_width = $validated['screen_width'] ?? $session->screen_width;
            $session->screen_height = $validated['screen_height'] ?? $session->screen_height;
            $session->last_seen_at = now();
            $session->save();

            return $session;
        });

        return response()->json([
            'ok' => true,
            'session_id' => $session->id,
            'max_scroll_percent' => $session->max_scroll_percent,
        ]);
    }

    private function resolveViewArticleId(int $articleId, string $ip, ?int $userId): ?int
    {
        if ($userId) {
            $view = ViewArticle::where('article_id', $articleId)
                ->where('user_id', $userId)
                ->first();

            if ($view) {
                return $view->id;
            }

            $view = ViewArticle::where('article_id', $articleId)
                ->where('ip', $ip)
                ->whereNull('user_id')
                ->first();

            return $view ? $view->id : null;
        }

        $view = ViewArticle::where('article_id', $articleId)
            ->where('ip', $ip)
            ->first();

        return $view ? $view->id : null;
    }

    private function detectDeviceType(string $userAgent): string
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        if ($agent->isTablet()) {
            return 'tablet';
        }

        if ($agent->isMobile()) {
            return 'mobile';
        }

        return 'desktop';
    }

    private function classifySource(string $referer, string $url): string
    {
        $utmSource = $this->queryValue($url, 'utm_source');
        if ($utmSource !== '') {
            return 'utm:' . mb_substr($utmSource, 0, 24);
        }

        $host = $this->normalizeHost($this->hostFromUrl($referer));
        if ($host === '') {
            return 'direct';
        }

        $currentHost = $this->normalizeHost(request()->getHost());
        if ($host === $currentHost || str_ends_with($host, '.' . $currentHost)) {
            return 'internal';
        }

        if (preg_match('/(^|\.)(yandex|google|bing|duckduckgo|mail|rambler)\./i', $host)) {
            return 'search';
        }

        if (preg_match('/(^|\.)(t\.co|x\.com|twitter\.com|facebook\.com|vk\.com|linkedin\.com|telegram\.org|t\.me)$/i', $host)) {
            return 'social';
        }

        return 'referral';
    }

    private function hostFromUrl(string $url): string
    {
        if ($url === '') {
            return '';
        }

        $host = parse_url($url, PHP_URL_HOST);

        return is_string($host) ? mb_strtolower($host) : '';
    }

    private function normalizeHost(string $host): string
    {
        return preg_replace('/^www\./i', '', $host) ?: $host;
    }

    private function queryValue(string $url, string $key): string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (!is_string($query) || $query === '') {
            return '';
        }

        parse_str($query, $params);

        return isset($params[$key]) && is_string($params[$key]) ? $params[$key] : '';
    }
}
