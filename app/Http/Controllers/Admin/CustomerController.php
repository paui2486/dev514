<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use Input;
use Session;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function customer()
    {
        return view('admin.dashboard.customer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function mailQA(Request $request)
    {
        // return Input::all();
        $mails = DB::table('users')->where('adminer', '>=', 1)->lists('email');
        $msg = '使用者： '. $request->username .'; 信箱： '. $request->email . '; 電話： '. $request->mobile . '; 問題: '. $request->comment;
        Mail::send('auth.emails.checkout', array('msg' => $msg),  function($message) use ($mails, $msg) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to($mails)->subject('客訴通知 : '. Auth::user()->name);
        });

        Session::flash('message', '提交完成，514 團隊將會努力地為您解決問題');
        return Redirect::to('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
