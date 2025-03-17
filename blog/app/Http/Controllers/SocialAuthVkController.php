<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthVkController extends Controller
{
    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect()
    {
//        if ($whereback == 'add_comment') {
//            $_SERVER['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'] . '#add_comment';
//        };
//        dd($_SERVER['HTTP_REFERER']);
//        return Socialite::driver('facebook')->redirect();
        var_dump("here");
        die();
    }

    public function callback($code, $state, $device_id)
    {
        var_dump("code", $_GET['code']);
        var_dump("state", $_GET['state']);
        var_dump("device_id", $_GET['device_id']);
        die();
//        $user = Socialite::driver('facebook')->user();
//        $facebookId = $user->getId();
//        $fileContents = file_get_contents($user->getAvatar());
//        Storage::put('public/user_avatars/' . $facebookId . '.jpg', $fileContents);
//        $avatar_url = Storage::url('public/user_avatars/' . $facebookId . '.jpg');
//        $user = $service->createOrGetUser($user, $avatar_url);
//        auth()->login($user);
////        dd($request->session()->previousUrl());
////        dd($request);
////        return redirect()->intended($_SERVER['HTTP_REFERER']);
//        if ($request->session()->previousUrl() == env('APP_URL') . '/redirect-add_comment') {
//            return redirect()->intended($_SERVER['HTTP_REFERER'] . '#add_comment');
//        }
//        return redirect()->intended($_SERVER['HTTP_REFERER']);

    }
}
