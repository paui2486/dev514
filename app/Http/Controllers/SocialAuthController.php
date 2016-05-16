<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Log;
use Input;
use Redirect;
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

    public function fbCallback(Request $request)
    {
        Log::error('SocialAuth Login');
        Log::error($request);
        $service = new SocialAccountService();

        $social_user = Socialite::driver('facebook')->user();
        Log::error(json_encode($social_user));

        $user = $service->createOrGetUser($social_user);
        Log::error(json_encode($user));

        auth()->login($user);
        return Redirect::intended();;
    }
}
