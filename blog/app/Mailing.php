<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Mailing extends Model
{
    protected $fillable = [
        'email',
        'url',
        'confirmed',
        'user_id',
        'ip',
        'user_agent',
        'locale',
        'referer',
    ];

    public static function createSubscriber($request)
    {
        $email = mb_strtolower(trim($request->email));

        $confirmedSubscriber = Mailing::where('email', $email)
            ->where('confirmed', 1)
            ->first();

        if ($confirmedSubscriber) {
            return $confirmedSubscriber;
        }

        $subscriber = Mailing::where('email', $email)
            ->where('confirmed', 0)
            ->first();

        if (!$subscriber) {
            $subscriber = new Mailing();
            $subscriber->email = $email;
            $subscriber->confirmed = 0;
        }

        $shouldResendConfirmation = !$subscriber->exists || !$subscriber->updated_at || $subscriber->updated_at->lt(now()->subDay());

        if ($shouldResendConfirmation) {
            $key = date('l jS \of F Y h:i:s A') . 'EsJeDLo%InYj' . random_int(1, 1000);
            $subscriber->url = md5(md5($key));
        }

        $subscriber->user_id = Auth::id();
        $subscriber->ip = $request->ip();
        $subscriber->user_agent = (string) $request->userAgent();
        $subscriber->locale = \App\Support\SiteLocale::resolve($request);
        $subscriber->referer = (string) $request->headers->get('referer');

        if (!$subscriber->save()) {
            return false;
        }

        if ($shouldResendConfirmation) {
            $subscriber->send_the_confirmation_link();
        }

        return $subscriber;
    }

    public function send_the_confirmation_link()
    {

        $data['subscriber'] = $this;
        $data['unsubscribeUrl'] = route('blog.unsubscribe_mailing', [
            'hash' => $this->url
        ]);
        $email = $this->email;
        $subject = 'Подтверждение подписки на сайт ';
        $subject .= env('APP_NAME');

        Mail::send('emails.subscribe_confirmation', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    public function send_the_final_confirmation()
    {
        $data['subscriber'] = $this;
        $data['unsubscribeUrl'] = route('blog.unsubscribe_mailing', [
            'hash' => $this->url
        ]);
        $subject = 'Успешная подписка на ';
        $subject .= env('APP_NAME');
        $email = $this->email;

        Mail::send('emails.subscribe_final_confirmation', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
