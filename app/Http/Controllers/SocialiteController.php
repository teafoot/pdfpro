<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback($driver)
    {
        $userData = Socialite::driver($driver)->user();

        // Manage your user data here and redirect users to their page
//        $data = [
//            'account_id' => $userData->getId(),
//            'name' => $userData->getName(),
//            'nickname' => $userData->getNickname(),
//            'email' => $userData->getEmail(),
//            'avatar' => $userData->getAvatar(),
//            'token' => $userData->token,
//            'token_secret' => $userData->tokenSecret ?? $userData->refreshToken,
//        ];
    }
}
