<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleReadSession;
use App\ViewArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminArticleAnalyticsController extends Controller
{
    private const PERIODS = [
        '7' => '7 дней',
        '30' => '30 дней',
        '90' => '90 дней',
        'all' => 'Все время',
    ];

    public function index(Request $request)
    {
        $period = (string) $request->query('period', '30');
        if (!array_key_exists($period, self::PERIODS)) {
            $period = '30';
        }

        $since = $period === 'all' ? null : now()->subDays((int) $period);

        $sessionQuery = ArticleReadSession::query();
        $viewQuery = ViewArticle::query();

        if ($since) {
            $sessionQuery->where('created_at', '>=', $since);
            $viewQuery->where('created_at', '>=', $since);
        }

        $sessionRows = (clone $sessionQuery)
            ->select(
                'article_id',
                DB::raw('COUNT(*) as sessions_count'),
                DB::raw('AVG(max_scroll_percent) as avg_scroll_percent'),
                DB::raw('AVG(active_seconds) as avg_active_seconds'),
                DB::raw('SUM(CASE WHEN reached_25 = 1 THEN 1 ELSE 0 END) as reached_25_count'),
                DB::raw('SUM(CASE WHEN reached_50 = 1 THEN 1 ELSE 0 END) as reached_50_count'),
                DB::raw('SUM(CASE WHEN reached_75 = 1 THEN 1 ELSE 0 END) as reached_75_count'),
                DB::raw('SUM(CASE WHEN reached_100 = 1 THEN 1 ELSE 0 END) as reached_100_count'),
                DB::raw('SUM(CASE WHEN max_scroll_percent < 25 THEN 1 ELSE 0 END) as drop_0_24'),
                DB::raw('SUM(CASE WHEN max_scroll_percent >= 25 AND max_scroll_percent < 50 THEN 1 ELSE 0 END) as drop_25_49'),
                DB::raw('SUM(CASE WHEN max_scroll_percent >= 50 AND max_scroll_percent < 75 THEN 1 ELSE 0 END) as drop_50_74'),
                DB::raw('SUM(CASE WHEN max_scroll_percent >= 75 AND max_scroll_percent < 95 THEN 1 ELSE 0 END) as drop_75_94'),
                DB::raw('SUM(CASE WHEN max_scroll_percent >= 95 THEN 1 ELSE 0 END) as complete_95_100')
            )
            ->groupBy('article_id')
            ->get()
            ->keyBy('article_id');

        $viewRows = (clone $viewQuery)
            ->select('article_id', DB::raw('COUNT(*) as views_count'))
            ->groupBy('article_id')
            ->get()
            ->keyBy('article_id');

        $articleIds = $sessionRows->keys()
            ->merge($viewRows->keys())
            ->unique()
            ->values();

        $articles = Article::with('blog_section')
            ->whereIn('id', $articleIds)
            ->get()
            ->keyBy('id');

        $rows = $this->buildRows($articleIds, $articles, $sessionRows, $viewRows);
        $totals = $this->buildTotals($rows);

        $recentSessions = (clone $sessionQuery)
            ->with(['article.blog_section'])
            ->orderByDesc('last_seen_at')
            ->limit(50)
            ->get();

        return view('admin.article_analytics.index', [
            'period' => $period,
            'periods' => self::PERIODS,
            'rows' => $rows,
            'totals' => $totals,
            'recentSessions' => $recentSessions,
        ]);
    }

    private function buildRows(Collection $articleIds, Collection $articles, Collection $sessionRows, Collection $viewRows): Collection
    {
        return $articleIds
            ->map(function ($articleId) use ($articles, $sessionRows, $viewRows) {
                $article = $articles->get($articleId);
                if (!$article) {
                    return null;
                }

                $session = $sessionRows->get($articleId);
                $views = $viewRows->get($articleId);
                $sessionsCount = (int) ($session->sessions_count ?? 0);

                $buckets = [
                    'drop_0_24' => (int) ($session->drop_0_24 ?? 0),
                    'drop_25_49' => (int) ($session->drop_25_49 ?? 0),
                    'drop_50_74' => (int) ($session->drop_50_74 ?? 0),
                    'drop_75_94' => (int) ($session->drop_75_94 ?? 0),
                    'complete_95_100' => (int) ($session->complete_95_100 ?? 0),
                ];

                $dominantBucket = collect($buckets)->sortDesc()->keys()->first();

                return [
                    'article' => $article,
                    'views_count' => (int) ($views->views_count ?? 0),
                    'total_views_count' => (int) ($article->views_count ?? 0),
                    'sessions_count' => $sessionsCount,
                    'avg_scroll_percent' => round((float) ($session->avg_scroll_percent ?? 0), 1),
                    'avg_active_seconds' => round((float) ($session->avg_active_seconds ?? 0)),
                    'reached_25_count' => (int) ($session->reached_25_count ?? 0),
                    'reached_50_count' => (int) ($session->reached_50_count ?? 0),
                    'reached_75_count' => (int) ($session->reached_75_count ?? 0),
                    'reached_100_count' => (int) ($session->reached_100_count ?? 0),
                    'completion_rate' => $sessionsCount > 0 ? round(((int) ($session->reached_100_count ?? 0) / $sessionsCount) * 100, 1) : 0,
                    'buckets' => $buckets,
                    'dominant_bucket' => $dominantBucket,
                    'dominant_bucket_label' => $this->bucketLabel($dominantBucket),
                ];
            })
            ->filter()
            ->sortByDesc(function (array $row) {
                return ($row['sessions_count'] * 1000000000) + ($row['views_count'] * 100000) + $row['total_views_count'];
            })
            ->values();
    }

    private function buildTotals(Collection $rows): array
    {
        $sessions = (int) $rows->sum('sessions_count');
        $weightedScroll = $rows->sum(fn (array $row) => $row['avg_scroll_percent'] * $row['sessions_count']);
        $completed = (int) $rows->sum('reached_100_count');
        $activeSeconds = $rows->sum(fn (array $row) => $row['avg_active_seconds'] * $row['sessions_count']);

        return [
            'views_count' => (int) $rows->sum('views_count'),
            'sessions_count' => $sessions,
            'avg_scroll_percent' => $sessions > 0 ? round($weightedScroll / $sessions, 1) : 0,
            'completion_rate' => $sessions > 0 ? round(($completed / $sessions) * 100, 1) : 0,
            'avg_active_seconds' => $sessions > 0 ? round($activeSeconds / $sessions) : 0,
        ];
    }

    private function bucketLabel(?string $bucket): string
    {
        return match ($bucket) {
            'drop_0_24' => 'до 25%',
            'drop_25_49' => '25-49%',
            'drop_50_74' => '50-74%',
            'drop_75_94' => '75-94%',
            'complete_95_100' => 'дочитывают',
            default => 'нет данных',
        };
    }
}
