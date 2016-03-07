<?php

namespace App\Http\Controllers;

use Auth;
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
        return view('');
    }

    public function profile()
    {
        $member = Auth::user();
        // $banners = DB::table('galleries')->find($id);
        return view('admin.member.create_edit', compact('member'));
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
