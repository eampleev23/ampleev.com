<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
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
            return true;
        }
        return false;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function parent_comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
