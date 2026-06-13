<?php

namespace App;

use App\Support\SiteLocale;
use Illuminate\Database\Eloquent\Model;

class ArticleFeedbackAnswer extends Model
{
    public const QUESTION_INTERESTING = 'interesting';
    public const QUESTION_CONTINUATION = 'continuation';
    public const ANSWER_YES = 'yes';
    public const ANSWER_NO = 'no';

    protected $fillable = [
        'article_id',
        'question_key',
        'answer',
        'user_id',
        'view_article_id',
        'is_owner',
        'owner_device_key',
        'owner_device_label',
        'ip',
        'user_agent',
        'locale',
        'referer',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
    ];

    public static function questions(?string $locale = null): array
    {
        $isEn = SiteLocale::normalize($locale ?? SiteLocale::RU) === SiteLocale::EN;

        return [
            self::QUESTION_INTERESTING => $isEn
                ? 'Was this article interesting to you?'
                : 'Вам была интересна данная статья?',
            self::QUESTION_CONTINUATION => $isEn
                ? 'Are you looking forward to the next part of the series?'
                : 'Вы ожидаете продолжения серии?',
        ];
    }

    public static function answerLabels(?string $locale = null): array
    {
        $isEn = SiteLocale::normalize($locale ?? SiteLocale::RU) === SiteLocale::EN;

        return [
            self::ANSWER_YES => $isEn ? 'Yes' : 'Да',
            self::ANSWER_NO => $isEn ? 'No' : 'Нет',
        ];
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewArticle()
    {
        return $this->belongsTo(ViewArticle::class);
    }
}
