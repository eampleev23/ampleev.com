<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewArticle extends Model
{

    protected $fillable = [
        'ip',
        'user_id',
    ];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
