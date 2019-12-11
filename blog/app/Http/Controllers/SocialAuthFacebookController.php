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
        $fileContents = file_get_contents($user->getAvatar());
        dd(Storage::put('avatars/' . $user->getId() . '.jpg', $fileContents));
        $user = $service->createOrGetUser($user);
        auth()->login($user);
        return redirect()->to('/home');
    }
}