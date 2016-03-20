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
                      ->where('categories.name', $category)
                      ->where('activities.title', $title)
                      ->select(array(
                        'activities.id' ,               'activities.title',           'activities.thumbnail',         'activities.description',     'activities.activity_start',  'activities.activity_end',
                        'activities.category_id',       'activities.remark',          'activities.time_range',
                        'categories.name as category',  'activities.description',
                      ))
                      ->where('activities.status', '>=', '2')
                      ->first();

        if (empty($activity)){
            return Redirect::back();
        } else {
            $tickets = DB::table('act_tickets')
                        ->where('activity_id', $activity->id)
                        ->where('left_over', '>', 0)
                        ->select(array(
                            'id', 'name',   'left_over',  'price', 'location',
                            'ticket_start', 'ticket_end', 'description',
                        ))
                        ->get();


            $weekday=['日', '一', '二', '三', '四', '五', '六'];
            $eventData = array();
            foreach ($tickets as $key => $ticket) {
                $data = array(
                  'date'         => preg_replace("/(.*)\s(.*)/", "$1", $ticket->ticket_start),
                  'badge'        => true,
                  'title'        => $ticket->id,
                  'name'         => $ticket->name,
                  'price'        => $ticket->price,
                  'location'     => $ticket->location,
                  'left_over'    => $ticket->left_over,
                  'weekday'      => $weekday[date('w', strtotime($activity->activity_start))],
                  'ticket_start' => $ticket->ticket_start,
                  'ticket_end'   => $ticket->ticket_end,
                  'description'  => $ticket->description,
                );
                array_push($eventData, $data);
            }

            return view('activity.purchase', compact('activity', 'eventData', 'tickets'));
        }
    }

    public function postPurchase(Request $request)
    {
        $ticket = DB::table('act_tickets')
                    ->where('id', $request->ticket_id)
                    ->where('left_over', '>=', $request->purchase_number)
                    ->first();

        if (empty($ticket)) {
            $result = Response::json(Array(
              'code'    => 402,
              'message' => 'Tickets is not enough!',
            ), 402);
            return $result;
        } else {
            $Pay2go     = new Pay2go();
            $merID      = env('Pay2go_ID',  11606075);
            $merKey     = env('Pay2go_Key', "7CPtmx1zm86jpLfWndymKbPmlyqP7oye");
            $merIV      = env('Pay2go_IV',  "1oInVJXhR3BhOQeb");
            $autoSubmit = TRUE;
            $title      = urldecode($request->segment(3));
            $ticketInfo = $request->activity . " - " . $ticket->name . " x " . $request->purchase_number;
            $result     = array (
                                "MerchantID"        =>  $merID,                 //	商店代號
                                "RespondType"	      =>  "JSON",                 //  回傳格式
                                "TimeStamp"		      =>  time(),                 //	時間戳記
                                "Version"		        =>  "1.1",                  //	串接版本
                                "MerchantOrderNo"	  =>  date("Ymdhis", time()), //	商店訂單編號
                                "Amt"		            =>  $request->purchase_result,          //	訂單金額
                                "ItemDesc"		      =>  $ticketInfo,        //	商品資訊
                                "LoginType"		      =>  "0",                    //	是否要登入智付寶會員
                                'Email'             =>  $request->user_email,
                                'OrderComment'      =>  'test comment',
                                'BARCODE'           =>  '1',
                                'TradeLimit'        =>  300,
                                'ReturnURL'         =>  url('purchase/result'),
                                // "NotifyURL"         =>  url('pay2go/callback'),
                            );

            $result["CheckValue"]	=   $Pay2go->get_check_value($result, $merKey, $merIV);

            $submitButtonStyle      =   "<input id='Pay2goMgr' name='submit' type='submit' value='送出' />";

            // Log::info($result);
            return $Pay2go->create_form($result, NULL, TRUE, $autoSubmit, 0, $submitButtonStyle);
            // return Input::all();
        }
    }

    public function postByPay2Go()
    {
        Log::error(Input::all());
        return true;
    }
}
