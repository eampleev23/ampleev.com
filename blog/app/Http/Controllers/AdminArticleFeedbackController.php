<?php

namespace App\Http\Controllers;

use App\ArticleFeedbackAnswer;
use Illuminate\Support\Facades\DB;

class AdminArticleFeedbackController extends Controller
{
    public function index()
    {
        $summaryRows = ArticleFeedbackAnswer::query()
            ->select('article_id', 'question_key', 'answer', DB::raw('COUNT(*) as answers_count'))
            ->with('article')
            ->groupBy('article_id', 'question_key', 'answer')
            ->orderBy('article_id')
            ->orderBy('question_key')
            ->get();

        $answers = ArticleFeedbackAnswer::query()
            ->with(['article', 'user', 'viewArticle'])
            ->latest()
            ->paginate(100);

        return view('admin.article_feedback.index', compact('summaryRows', 'answers'));
    }
}
