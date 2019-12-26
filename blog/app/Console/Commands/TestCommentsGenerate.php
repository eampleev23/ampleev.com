<?php

namespace App\Console\Commands;

use App\Article;
use App\Comment;
use Illuminate\Console\Command;

class TestCommentsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:generate {article_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test html generating by recursion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $article = Article::find($this->argument('article_id'));
        echo $article->title . "\n";

        $comments = Comment::with('user')->where([
            ['article_id', '=', $article->id],
            ['comment_id', '=', null],
        ])->get();

        echo "count (comments) " . count($comments) . "\n";

        $resultStr = '';
        echo "присвоили пустое значение resultStr\n";
        echo "Запустили цикл\n";

        $resultStr .= '<ol class="comments">';

        for ($i = 0; $i < count($comments); $i++) {
            echo "Запустили итерацию родительского цикла №" . $i . "\n";

//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '<li id="';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= 'comment_';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= $comments[$i]->id;
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '" class="comment">';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '<div class="d-flex align-items-center text-small">';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '<img src="';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= $comments[$i]->user->avatar_path;
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '"alt="Sarah Priestly" class="avatar avatar-sm mr-2">';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '<div class="text-dark mr-1">';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= $comments[$i]->user->name;
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '</div>';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '<div class="text-muted">';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= $comments[$i]->get_nice_time_created();
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '</div>';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '</div><div class="my-2">';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= $comments[$i]->content;
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '</div><div>';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '<span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                      data-answer_to_comment_id="';
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= $comments[$i]->id;
//            echo "resultStr = " . $resultStr . "\n";
            $resultStr .= '">Ответить</span></div>';
//            echo "comments[i]->id = " . $comments[$i]->id . "\n";
            $resultStr .= $comments[$i]->getChildsForConsole();
            $resultStr .= '</li>';
            echo "Вернулись в цикл, который вызвал getChildForConsole\n";

//            echo "resultStr = " . $resultStr . "\n";
        }
        $resultStr .= '</ol>';
        echo $resultStr;

        echo "the end\n";
    }
}
