<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Mailing extends Model
{
    public static function commentNotification($receiving_user, $init_user)
    {
        $data['content'] = 'It works!';
        $email = 'e+1@mpleev.com';
        $subject = 'тестовое письмо';

        Mail::send('emails.tpl', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
