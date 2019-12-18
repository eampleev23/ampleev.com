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
        $comment->article_id = $request->article_id;

        dd($comment);
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
