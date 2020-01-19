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

        $data['content'] = 'It works!';
        $email = 'e+1@mpleev.com';
        $subject = 'тестовое письмо';

        Mail::send('emails.tpl', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    public function test_view_mailing_lists_confirmation()
    {

//        return view('utility.confirmation_mailing_lists');
        return view('utility.confirmed_mailing_lists');
    }
}