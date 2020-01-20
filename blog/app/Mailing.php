<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Mailing extends Model
{

    public static function createSubscriber($request)
    {
        $subscriber = new Mailing();
        $subscriber->email = $request->email;
        $key = date('l jS \of F Y h:i:s A') . 'EsJeDLo%InYj' . random_int(1, 1000);
        $subscriber->url = md5(md5($key));
        $subscriber->confirmed = 0;

        if ($subscriber->save()) {

            $subscriber->send_the_confirmation_link();

            return $subscriber;
        }
        return false;
    }

    public function send_the_confirmation_link()
    {

        $data['subscriber'] = $this;
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
        $subject = 'Успешная подписка на ';
        $subject .= env('APP_NAME');

        Mail::send('emails.subscribe_confirmation', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
