<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleFeedbackAnswer;
use App\Support\SiteLocale;
use App\ViewArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|integer|exists:articles,id',
            'question_key' => 'required|in:' . implode(',', [
                ArticleFeedbackAnswer::QUESTION_INTERESTING,
                ArticleFeedbackAnswer::QUESTION_CONTINUATION,
            ]),
            'answer' => 'required|in:' . implode(',', [
                ArticleFeedbackAnswer::ANSWER_YES,
                ArticleFeedbackAnswer::ANSWER_NO,
            ]),
        ]);

        $article = Article::where('id', $validated['article_id'])
            ->where('show_feedback_questions', true)
            ->firstOrFail();

        $ip = $request->ip();
        $userId = Auth::id();
        $locale = SiteLocale::resolve($request);

        $answer = DB::transaction(function () use ($article, $validated, $ip, $userId, $locale, $request) {
            $baseQuery = ArticleFeedbackAnswer::where('article_id', $article->id)
                ->where('question_key', $validated['question_key']);

            if ($userId) {
                $existingAnswer = (clone $baseQuery)
                    ->where('user_id', $userId)
                    ->lockForUpdate()
                    ->first();

                if ($existingAnswer) {
                    return $existingAnswer;
                }

                $existingAnswerByIp = (clone $baseQuery)
                    ->where('ip', $ip)
                    ->whereNull('user_id')
                    ->lockForUpdate()
                    ->first();

                if ($existingAnswerByIp) {
                    $existingAnswerByIp->user_id = $userId;
                    $existingAnswerByIp->save();

                    return $existingAnswerByIp;
                }
            } else {
                $existingAnswer = (clone $baseQuery)
                    ->where('ip', $ip)
                    ->lockForUpdate()
                    ->first();

                if ($existingAnswer) {
                    return $existingAnswer;
                }
            }

            return ArticleFeedbackAnswer::create([
                'article_id' => $article->id,
                'question_key' => $validated['question_key'],
                'answer' => $validated['answer'],
                'user_id' => $userId,
                'view_article_id' => $this->resolveViewArticleId($article->id, $ip, $userId),
                'ip' => $ip,
                'user_agent' => (string) $request->userAgent(),
                'locale' => $locale,
                'referer' => (string) $request->headers->get('referer'),
            ]);
        });

        return response()->json([
            'ok' => true,
            'question_key' => $answer->question_key,
            'answer' => $answer->answer,
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
}
