<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\MyTime;
use Illuminate\Support\Facades\Mail;

class Comment extends Model
{
    public $iterations = 5;
    protected $fillable = [
        'content',
        'comment_id',
    ];

    public static function createComment($request)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->article_id = (int)$request->article_id;
        $comment_id = $request->comment_id;

        if ($comment_id != '0') {

            $comment->comment_id = (int)$request->comment_id;


        }

        if ($comment->save()) {

            $comment->articlesAuthorNotification();
            return $comment;

        }
        return false;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function get_nice_time_created()
    {
        return MyTime::new_time($this->created_at);
    }

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function parent_comment()
    {
        return $this->belongsTo('App\Comment');
    }

    public static function getAllCommentsHtml($article)
    {
        $comments = Comment::with('user')->where([
            ['article_id', '=', $article->id],
            ['comment_id', '=', null],
        ])->get();

        $resultStr = '';
//        echo "присвоили пустое значение resultStr\n";
//        echo "Запустили цикл\n";

        $resultStr .= '<ol class="comments">';

        for ($i = 0; $i < count($comments); $i++) {
//            echo "Запустили итерацию родительского цикла №" . $i . "\n";

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

            if (Auth::check()) {
                $resultStr .= '<span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                      data-answer_to_comment_id="';
//            echo "resultStr = " . $resultStr . "\n";
                $resultStr .= $comments[$i]->id;
//            echo "resultStr = " . $resultStr . "\n";
                $resultStr .= '">Ответить</span></div>';
            } else {
                $resultStr .= '<span onclick="show_modal_sign_in();" class="text-small answer-to-comment-link">Ответить</span></div>';
            }


//            echo "comments[i]->id = " . $comments[$i]->id . "\n";
            $resultStr .= $comments[$i]->getChilds();
            $resultStr .= '</li>';
//            echo "Вернулись в цикл, который вызвал getChildForConsole\n";

//            echo "resultStr = " . $resultStr . "\n";
        }
        $resultStr .= '</ol>';
        return $resultStr;
    }

    public function getChilds()
    {
//        echo "Запустили  getChildsForConsole\n";
        $resultStr = '';

//        echo "Ищем все комментарии с артикл ид " . $this->article_id . " и с коммент id " . $this->id . "\n";
        $comments = Comment::with('user')->where([
            ['article_id', '=', $this->article_id],
            ['comment_id', '=', $this->id],
        ])->get();
//        echo "Получили такое количество: " . count($comments) . "\n";

        if (count($comments) > 0) {
            for ($i = 0; $i < count($comments); $i++) {
//                echo "Запустили в модели итерацию: " . $i . "\n";
                if ($i == 0) {
                    $resultStr .= '<ol class="comments">';
                }
//                echo "resultStr = " . $resultStr . "\n";
                $resultStr .= '<li id="';
                $resultStr .= 'comment_';
                $resultStr .= $comments[$i]->id;
                $resultStr .= '" class="comment">';
                $resultStr .= '<div class="d-flex align-items-center text-small">'; // ok
                $resultStr .= '<img src="'; // ok
                $resultStr .= $comments[$i]->user->avatar_path; // ok
                $resultStr .= '"alt="Sarah Priestly" class="avatar avatar-sm mr-2">';
                $resultStr .= '<div class="text-dark mr-1">';
                $resultStr .= $comments[$i]->user->name;
                $resultStr .= '</div>';
                $resultStr .= '<div class="text-muted">';
                $resultStr .= $comments[$i]->get_nice_time_created();
                $resultStr .= '</div>';
                $resultStr .= '</div><div class="my-2">';
                $resultStr .= $comments[$i]->content;
                $resultStr .= '</div><div>';

                if (Auth::check()) {
                    $resultStr .= '<span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                      data-answer_to_comment_id="';
//            echo "resultStr = " . $resultStr . "\n";
                    $resultStr .= $comments[$i]->id;
//            echo "resultStr = " . $resultStr . "\n";
                    $resultStr .= '">Ответить</span></div>';
                } else {
                    $resultStr .= '<span onclick="show_modal_sign_in();" class="text-small answer-to-comment-link">Ответить</span></div>';
                }
//                echo "Добрались до рекурсии\n";
                $resultStr .= $comments[$i]->getChilds();
                if ($i == count($comments) - 1) {
                    $resultStr .= '</ol>';
                }

            }
            $resultStr .= '</li>';
        }
        return $resultStr;


//        $comments = Comment::with('user')->where([
//            ['article_id', '=', $article->id],
//            ['comment_id', '=', null],
//        ])->get();
//
//        for ($i = 0; $i < count($comments); $i++) {
//            $allComments[$i] = Comment::with('user')->where([
//                ['article_id', '=', $article->id],
//                ['comment_id', '=', $comments[$i]->id],
//            ])->get();
//        }
    }


    public function getChildsForConsole()
    {
        echo "Запустили  getChildsForConsole\n";
        $resultStr = '';

        echo "Ищем все комментарии с артикл ид " . $this->article_id . " и с коммент id " . $this->id . "\n";
        $comments = Comment::with('user')->where([
            ['article_id', '=', $this->article_id],
            ['comment_id', '=', $this->id],
        ])->get();
        echo "Получили такое количество: " . count($comments) . "\n";

        if (count($comments) > 0) {
            for ($i = 0; $i < count($comments); $i++) {
                echo "Запустили в модели итерацию: " . $i . "\n";
                if ($i == 0) {
                    $resultStr .= '<ol class="comments">';
                }
//                echo "resultStr = " . $resultStr . "\n";
                $resultStr .= '<li id="';
                $resultStr .= 'comment_';
                $resultStr .= $comments[$i]->id;
                $resultStr .= '" class="comment">';
                $resultStr .= '<div class="d-flex align-items-center text-small">'; // ok
                $resultStr .= '<img src="'; // ok
                $resultStr .= $comments[$i]->user->avatar_path; // ok
                $resultStr .= '"alt="Sarah Priestly" class="avatar avatar-sm mr-2">';
                $resultStr .= '<div class="text-dark mr-1">';
                $resultStr .= $comments[$i]->user->name;
                $resultStr .= '</div>';
                $resultStr .= '<div class="text-muted">';
                $resultStr .= $comments[$i]->get_nice_time_created();
                $resultStr .= '</div>';
                $resultStr .= '</div><div class="my-2">';
                $resultStr .= $comments[$i]->content;
                $resultStr .= '</div><div>';
                $resultStr .= '<span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                      data-answer_to_comment_id="';
                $resultStr .= $comments[$i]->id;
                $resultStr .= '">Ответить</span></div>';
                echo "Добрались до рекурсии\n";
                $resultStr .= $comments[$i]->getChildsForConsole();
                if ($i == count($comments) - 1) {
                    $resultStr .= '</ol>';
                }

            }
            $resultStr .= '</li>';
        }
        return $resultStr;

    }

    public function articlesAuthorNotification()
    {
        $article = Article::find($this->article_id);
        $data['articlesAuthorName'] = User::find($article->user_id);
        $email = 'e+1@mpleev.com';
        $subject = 'тестовое письмо';

        Mail::send('emails.comment_notification', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
