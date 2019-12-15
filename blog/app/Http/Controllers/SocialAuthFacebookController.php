<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthFacebookController extends Controller
{
    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service)
    {

        $user = Socialite::driver('facebook')->user();
        $facebookId = $user->getId();

        $fileContents = file_get_contents($user->getAvatar());
        Storage::put('public/user_avatars/' . $facebookId . '.jpg', $fileContents);
        $avatar_url = Storage::url('public/user_avatars/' . $facebookId . '.jpg');
        $user = $service->createOrGetUser($user, $avatar_url);
        auth()->login($user);
        $uri = \request()->path();
        dd($uri);

//        return redirect()->intended('/blog');

    }
}