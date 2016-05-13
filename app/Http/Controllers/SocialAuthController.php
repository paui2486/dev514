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
        $service = new SocialAccountService();
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        Log::error(json_encode($user));

        auth()->login($user);
        return Redirect::intended();;
    }
}
