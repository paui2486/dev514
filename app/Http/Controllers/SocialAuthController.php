<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Socialite;
use App\Http\Requests;
use App\SocialAccountService;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
//        $user = Socialite::driver('facebook')->user();
//
//        return response()->json($user);
//
        $service = new SocialAccountService();
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        auth()->login($user);

        return redirect()->to('/');
    }
}
