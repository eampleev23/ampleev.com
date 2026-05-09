<?php

namespace App\Http\Controllers;

use App\Mailing;

class AdminMailingSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Mailing::query()
            ->with('user')
            ->latest()
            ->paginate(100);

        return view('admin.mailing_subscribers.index', compact('subscribers'));
    }
}
