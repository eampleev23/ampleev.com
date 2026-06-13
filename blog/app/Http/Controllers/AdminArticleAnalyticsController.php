<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleFeedbackAnswer;
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
        $feedbackQuery = ArticleFeedbackAnswer::query();

        if ($since) {
            $sessionQuery->where('created_at', '>=', $since);
            $viewQuery->where('created_at', '>=', $since);
            $feedbackQuery->where('created_at', '>=', $since);
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

        $feedbackRows = (clone $feedbackQuery)
            ->select('article_id', 'question_key', 'answer', DB::raw('COUNT(*) as answers_count'))
            ->groupBy('article_id', 'question_key', 'answer')
            ->get()
            ->groupBy('article_id');

        $feedbackCorrelationRows = $this->buildFeedbackCorrelationQuery($since)
            ->get()
            ->groupBy('article_id');

        $articleIds = $sessionRows->keys()
            ->merge($viewRows->keys())
            ->merge($feedbackRows->keys())
            ->unique()
            ->values();

        $articles = Article::with('blog_section')
            ->whereIn('id', $articleIds)
            ->get()
            ->keyBy('id');

        $rows = $this->buildRows($articleIds, $articles, $sessionRows, $viewRows, $feedbackRows, $feedbackCorrelationRows);
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

    private function buildFeedbackCorrelationQuery(?\DateTimeInterface $since)
    {
        $query = ArticleFeedbackAnswer::query()
            ->from('article_feedback_answers as f')
            ->leftJoin('article_read_sessions as s', function ($join) {
                $join->on('s.view_article_id', '=', 'f.view_article_id')
                    ->on('s.article_id', '=', 'f.article_id');
            })
            ->select(
                'f.article_id',
                'f.question_key',
                'f.answer',
                DB::raw('COUNT(*) as answers_count'),
                DB::raw('SUM(CASE WHEN s.id IS NOT NULL THEN 1 ELSE 0 END) as linked_sessions_count'),
                DB::raw('AVG(s.max_scroll_percent) as avg_scroll_percent'),
                DB::raw('AVG(s.active_seconds) as avg_active_seconds'),
                DB::raw('SUM(CASE WHEN s.reached_100 = 1 THEN 1 ELSE 0 END) as reached_100_count')
            )
            ->groupBy('f.article_id', 'f.question_key', 'f.answer');

        if ($since) {
            $query->where('f.created_at', '>=', $since);
        }

        return $query;
    }

    private function buildRows(
        Collection $articleIds,
        Collection $articles,
        Collection $sessionRows,
        Collection $viewRows,
        Collection $feedbackRows,
        Collection $feedbackCorrelationRows
    ): Collection
    {
        return $articleIds
            ->map(function ($articleId) use ($articles, $sessionRows, $viewRows, $feedbackRows, $feedbackCorrelationRows) {
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
                    'feedback' => $this->buildFeedbackSummary(
                        $feedbackRows->get($articleId, collect()),
                        $feedbackCorrelationRows->get($articleId, collect())
                    ),
                ];
            })
            ->filter()
            ->sortByDesc(function (array $row) {
                return ($row['sessions_count'] * 1000000000) + ($row['views_count'] * 100000) + $row['total_views_count'];
            })
            ->values();
    }

    private function buildFeedbackSummary(Collection $feedbackRows, Collection $correlationRows): array
    {
        $questions = [
            ArticleFeedbackAnswer::QUESTION_INTERESTING,
            ArticleFeedbackAnswer::QUESTION_CONTINUATION,
        ];

        $summary = [
            'total_answers' => 0,
        ];

        foreach ($questions as $questionKey) {
            $summary[$questionKey] = [
                'yes' => 0,
                'no' => 0,
                'total' => 0,
                'yes_rate' => null,
                'linked_sessions_count' => 0,
                'avg_scroll_percent' => null,
                'avg_active_seconds' => null,
                'reached_100_count' => 0,
                'completion_rate' => null,
            ];
        }

        foreach ($feedbackRows as $row) {
            if (!isset($summary[$row->question_key])) {
                continue;
            }

            $answer = $row->answer === ArticleFeedbackAnswer::ANSWER_NO
                ? ArticleFeedbackAnswer::ANSWER_NO
                : ArticleFeedbackAnswer::ANSWER_YES;
            $count = (int) $row->answers_count;

            $summary[$row->question_key][$answer] += $count;
            $summary[$row->question_key]['total'] += $count;
            $summary['total_answers'] += $count;
        }

        foreach ($correlationRows as $row) {
            if (!isset($summary[$row->question_key])) {
                continue;
            }

            $linkedSessions = (int) ($row->linked_sessions_count ?? 0);
            if ($linkedSessions <= 0) {
                continue;
            }

            $summary[$row->question_key]['linked_sessions_count'] += $linkedSessions;
            $summary[$row->question_key]['reached_100_count'] += (int) ($row->reached_100_count ?? 0);
            $summary[$row->question_key]['avg_scroll_percent'] = $this->weightedAverage(
                $summary[$row->question_key]['avg_scroll_percent'],
                $summary[$row->question_key]['linked_sessions_count'] - $linkedSessions,
                (float) ($row->avg_scroll_percent ?? 0),
                $linkedSessions
            );
            $summary[$row->question_key]['avg_active_seconds'] = $this->weightedAverage(
                $summary[$row->question_key]['avg_active_seconds'],
                $summary[$row->question_key]['linked_sessions_count'] - $linkedSessions,
                (float) ($row->avg_active_seconds ?? 0),
                $linkedSessions,
                0
            );
            $summary[$row->question_key]['completion_rate'] = round(
                ($summary[$row->question_key]['reached_100_count'] / $summary[$row->question_key]['linked_sessions_count']) * 100,
                1
            );
        }

        foreach ($questions as $questionKey) {
            $total = $summary[$questionKey]['total'];
            $summary[$questionKey]['yes_rate'] = $total > 0
                ? round(($summary[$questionKey]['yes'] / $total) * 100, 1)
                : null;
        }

        return $summary;
    }

    private function weightedAverage(?float $currentValue, int $currentWeight, float $newValue, int $newWeight, int $precision = 1): float
    {
        $totalWeight = $currentWeight + $newWeight;
        if ($totalWeight <= 0) {
            return 0;
        }

        $weightedValue = (($currentValue ?? 0) * $currentWeight) + ($newValue * $newWeight);

        return round($weightedValue / $totalWeight, $precision);
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
            'feedback_answers_count' => (int) $rows->sum(fn (array $row) => $row['feedback']['total_answers']),
            'feedback_interesting_yes_rate' => $this->weightedFeedbackYesRate($rows, ArticleFeedbackAnswer::QUESTION_INTERESTING),
            'feedback_continuation_yes_rate' => $this->weightedFeedbackYesRate($rows, ArticleFeedbackAnswer::QUESTION_CONTINUATION),
            'feedback_linked_sessions_count' => (int) $rows->sum(function (array $row) {
                return $row['feedback'][ArticleFeedbackAnswer::QUESTION_INTERESTING]['linked_sessions_count']
                    + $row['feedback'][ArticleFeedbackAnswer::QUESTION_CONTINUATION]['linked_sessions_count'];
            }),
        ];
    }

    private function weightedFeedbackYesRate(Collection $rows, string $questionKey): ?float
    {
        $total = (int) $rows->sum(fn (array $row) => $row['feedback'][$questionKey]['total']);
        if ($total <= 0) {
            return null;
        }

        $yes = (int) $rows->sum(fn (array $row) => $row['feedback'][$questionKey]['yes']);

        return round(($yes / $total) * 100, 1);
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
