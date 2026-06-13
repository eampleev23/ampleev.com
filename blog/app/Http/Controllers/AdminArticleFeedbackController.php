<?php

namespace App\Http\Controllers;

use App\ArticleFeedbackAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminArticleFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $includeOwner = $request->boolean('include_owner');

        $baseQuery = ArticleFeedbackAnswer::query();
        if (!$includeOwner) {
            $baseQuery->where('is_owner', false);
        }

        $summaryRows = (clone $baseQuery)
            ->select('article_id', 'question_key', 'answer', DB::raw('COUNT(*) as answers_count'))
            ->with('article')
            ->groupBy('article_id', 'question_key', 'answer')
            ->orderBy('article_id')
            ->orderBy('question_key')
            ->get();

        $answers = (clone $baseQuery)
            ->with(['article', 'user', 'viewArticle'])
            ->latest()
            ->paginate(100)
            ->appends($request->query());

        return view('admin.article_feedback.index', compact('summaryRows', 'answers', 'includeOwner'));
    }
}
