<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;
use Log;
use Form;
use Auth;
use Mail;
use Input;
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
                    ->leftJoin('activities', 'act_tickets.activity_id', '=', 'activities.id')
                    ->where('act_tickets.id', $request->ticket_id)
                    ->where('act_tickets.left_over', '>=', $request->purchase_number)
                    ->select(array(
                      'act_tickets.id', 'act_tickets.price', 'act_tickets.left_over', 'act_tickets.name',  'act_tickets.activity_id',
                      'activities.title', 'activities.host_id', 'activities.location', 'activities.remark'
                    ))
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
                                'OrderComment'      =>  $ticket->remark,
                                'BARCODE'           =>  '1',
                                'TradeLimit'        =>  300,
                                'ReturnURL'         =>  url('purchase/result'),
                            );

            $result["CheckValue"]	= $Pay2go->get_check_value($result, $merKey, $merIV);
            $submitButtonStyle    = "<input id='Pay2goMgr' name='submit' type='submit' value='送出' />";

            $user = DB::table('users')->where('email', $request->email)->first();
            if(empty($user)){
                $confirmation_code = str_random(30);

                $user_id = DB::table('users')->insertGetId(
                    array(
                      'name'              => $request->name,
                      'phone'             => $request->mobile,
                      'email'             => $request->email,
                      'confirmation_code' => $confirmation_code,
                    )
                );

                Mail::send('auth.emails.verify', array('confirmation_code'=>$confirmation_code), function($message) {
                    $message->from('us@example.com', 'Laravel');
                    $message->to(Input::get('email'), Input::get('name'))
                        ->subject('Verify your email address');
                });

                Auth::loginUsingId($user_id);
            }

            $storeOrder = array(
                            'MerchantID'      => $merID,
                            'MerchantOrderNo' => $result['MerchantOrderNo'],
                            'TotalPrice'      => $result['Amt'],
                            'ItemDesc'        => $result['ItemDesc'],
                            'OrderComment'    => $result['OrderComment'],
                            'user_id'         => Auth::id(),
                            'user_email'      => $request->email,
                            'user_phone'      => $request->mobile,
                            'hoster_id'       => $ticket->host_id,
                            'activity_id'     => $ticket->activity_id,
                            'activity_name'   => $ticket->title,
                            'ticket_id'       => $ticket->id,
                            'ticket_price'    => $ticket->price,
                            'created_at'      => date("Y-m-d H:i:s"),
                          );

            $insertOrder = DB::table('orders')->insert($storeOrder);
            return $Pay2go->create_form($result, NULL, TRUE, $autoSubmit, 0, $submitButtonStyle);
        }
    }

    public function postByPay2Go(Request $request)
    {
        if( $request->Status != "SUCCESS" ) {
            Log::error('交易失敗');
            Log::info(Response::json(Input::all()));
            return Redirect::to('/');
        } else {
            $result = json_decode($request->Result,true);
        }

        $updateArray = array(
            'TradeNo'         => $result->TradeNo,
            'MerchantOrderNo' => $result->MerchantOrderNo,
            'CheckCode'       => $result->CheckCode,
            'EscrowBank'      => $reuslt->EscrowBank,
            'Card6No'         => $result->Card6No,
            'Card4No'         => $result->Card4No,
            'InstFirst'       => $result->InstFirst,
            'InstEach'        => $result->InstEach,
            'Inst'            => $result->Inst,
            'IP'              => $result->IP,
            'PayTime'         => $result->PayTime,
            'OrderResult'     => $result,
            'updated_at'      => date("Y-m-d H:i:s"),
        );

        $info = DB::table('orders')
                  ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                  ->leftJoin('activities',  'orders.activity_id', '=', 'activities.id')
                  ->leftJoin('act_tickets', 'orders.ticket_id',   '=', 'act_tickets.id')
                  ->select(array(
                      'orders.id', 'orders.user_name', 'orders.user_email', 'orders.user_phone', 'orders.ticket_number', 'orders.TotalPrice',
                      'orders.PayTime',   'activities.title as activity_name',      'activities.location as activity_location',
                      'act_tickets.name as ticket_name',  'act_tickets.ticket_start', 'act_tickets.ticket_end', 'orders.ticket_id'
                  ))
                  ->where('MerchantOrderNo', $result->MerchantOrderNo)
                  ->first();

        DB::table('orders')->where('id', $info->id)->update($updateArray);
        // 需要再設計交易失敗回流機制
        DB::table('act_tickets')->where('id', $info->ticket_id)->decrement('left_over');

        $ticket = array(
            'TradeNo'           => $result->TradeNo,
            'TradeTime'         => $result->PayTime,
            'TotalPrice'        => $result->Amt,
            'user_name'         => $info->user_name,
            'user_phone'        => $info->users_phone,
            'user_email'        => $info->user_email,
            'activity_name'     => $info->activity_name,
            'activity_location' => $info->activity_location,
            'ticket_name'       => $info->ticket_name,
            'ticket_number'     => $info->ticket_number,
            'ticket_day'        => preg_replace("/(.*)\s(.*):\d+/", "$1", $info->ticket_start),
            'ticket_start'      => preg_replace("/(.*)\s(.*):\d+/", "$2", $info->ticket_start),
            'ticket_end'        => preg_replace("/(.*)\s(.*):\d+/", "$2", $info->ticket_end),
        );

        return view('activity.ticket', compact('ticket'));
    }
}
