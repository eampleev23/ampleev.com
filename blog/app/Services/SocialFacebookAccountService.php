<?php

namespace App\Services;

use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Storage;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $avatarUrl)
    {
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();

            /*Здесь попробую аватарку получить*/
//            $fileContents = file_get_contents($user->getAvatar());
//            Storage::disk('local')->put(public_path() . '../storage/app/public/user_avatars/' . $user->getId() . ".jpg",
//                $fileContents);


//            File::put(public_path() . '../storage/app/public/user_avatars/' . $user->getId() . ".jpg", $fileContents);

            if (!$user) {
//                dd('here we are', '$avatarUrl ' . $avatarUrl);
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1, 10000)),
                    'avatar_path' => $avatarUrl,
                ]);
                dd($user);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}