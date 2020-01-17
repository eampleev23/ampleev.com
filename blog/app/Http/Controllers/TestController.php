<?php

namespace App\Http\Controllers;

use App\Mail\TestAmazonSes;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{

    public function show_nav()
    {
        return view('test.navigation');
    }

    public function show_modals()
    {
        return view('test.modals');
    }

    public function show_article_test()
    {
        return view('test.article');
    }

    public function test_aws()
    {
//        Mail::to('e+1@mpleev.com')->send(new TestAmazonSes('It works!'));

        $data['content'] = 'It works!';
//        $message = ' [ message ] ';
        $email = 'e+1@mpleev.com';
        $subject = 'тестовое письмо';

        Mail::send('emails.tpl', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}