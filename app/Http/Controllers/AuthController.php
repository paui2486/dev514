<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('auth.pages.profile');
    }

    public function follows()
    {
        return view('auth.pages.follows');
    }

    public function friends()
    {
        return view('auth.pages.friends');
    }

    public function activitys()
    {
        return view('auth.pages.activitys');
    }

    public function dashboard()
    {
        return view('admin.dashboard.index');
    }
}
