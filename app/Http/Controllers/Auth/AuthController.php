<?php

namespace App\Http\Controllers\Auth;

use Log;
use Auth;
use Input;
use Response;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
//    protected $username = 'phone';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'phone'    => 'required|unique:users,phone|max:255',
            'email'    => 'required|unique:users,email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function postLogin(Request $request)
    {
        // $this->validate($request, [
        //     'phone' => 'required|phone', 'password' => 'required',
        // ]);
        setcookie("account",  $request->account,  time()+60*60*24*30); // retire one month later;
        setcookie("remember", $request->remember, time()+60*60*24*30);
        // $credentials = $this->getCredentials($request);

        if (Auth::attempt(['email' => $request->account, 'password' => $request->password], $request->has('remember')) ||
              Auth::attempt(['phone' => $request->account, 'password' => $request->password], $request->has('remember'))) {
            return redirect()->intended($this->redirectPath());
        }

        return redirect($request->url())
            ->withInput($request->only('phone', 'remember'))
            ->withFlashmessage($this->getFailedLoginMessage());
    }

    public function postRegister(Request $request)
    {
        return Input::all();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // Log::error($data);
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => bcrypt($data['password']),
        ]);
    }
}
