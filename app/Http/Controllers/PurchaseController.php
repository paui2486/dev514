<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;
use Log;
use Form;
use Input;
// use Request;
use Response;
use Redirect;
use App\Pay2go;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PurchaseController extends controller
{
    public function index()
    {
        //
    }

    public function showPurchase($category, $title)
    {
        $activity = DB::table('activities')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->leftJoin('users', 'users.id', '=', 'activities.host_id')
                      ->where('categories.name', $category)
                      ->where('activities.title', $title)
                      ->select(array(
                        'activities.id' ,       'activities.title',           'activities.tag_ids',
                        'activities.thumbnail', 'activities.description',     'activities.location',
                        'activities.content',   'activities.activity_start',  'activities.activity_end',
                        'activities.counter',   'activities.category_id',     'categories.name as category',
                        'users.name as hoster', 'users.avatar as host_photo', 'users.description as host_destricption'
                      ))
                      ->where('activities.status', '>=', '2')
                      ->first();

        if (empty($activity)){
            return Redirect::to('');
        } else {
            $tickets = DB::table('act_tickets')
                        ->where('activity_id', $activity->id)
                        ->select(array(
                            'id',   'name', 'left_over',  'run_time', 'price',
                            'ticket_start', 'ticket_end', 'location', 'description'
                        ))
                        ->get();
            return view('activity.purchase', compact('activity', 'tickets'));
        }
    }

    public function postPurchase(Request $request)
    {
        $ticket = DB::table('act_tickets')
                    ->where('id', $request->ticket)
                    ->where('left_over', '>=', $request->number)
                    ->first();

        if (empty($ticket)) {
            return Redirect::back();
        } else {
            $Pay2go     = new Pay2go();
            $merID      = env('Pay2go_ID', '11606075');
            $merKey     = env('Pay2go_Key', "7CPtmx1zm86jpLfWndymKbPmlyqP7oye");
            $merIV      = env('Pay2go_IV', "1oInVJXhR3BhOQeb");
            $autoSubmit = TRUE;
            $title      = urldecode($request->segment(3));
            $result     = array (
                                "MerchantID"        =>  $merID,                 //	商店代號
                                "RespondType"	      =>  "JSON",                 //  回傳格式
                                "TimeStamp"		      =>  time(),                 //	時間戳記
                                "Version"		        =>  "1.1",                  //	串接版本
                                "MerchantOrderNo"	  =>  date("Ymdhis", time()), //	商店訂單編號
                                "Amt"		            =>  $ticket->price * $request->number,          //	訂單金額
                                "ItemDesc"		      =>  $title . " - " .$ticket->name,        //	商品資訊
                                "LoginType"		      =>  "0",                    //	是否要登入智付寶會員
                                'Email'             =>  $request->email,
                            );

            //  檢查碼
            $result["CheckValue"]	=   $Pay2go->get_check_value($result, $merKey, $merIV);

            //  送出按鈕
            $submitButtonStyle      =   "<input id='Pay2goMgr' name='submit' type='submit' value='送出' />";

            return $Pay2go->create_form($result, NULL, TRUE, $autoSubmit, 0, $submitButtonStyle);

            return Input::all();
        }
    }

    public function mpg_unit()
    {

    }
}
