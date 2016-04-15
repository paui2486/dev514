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
use Session;
use Response;
use Redirect;
use App\Pay2go;
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PurchaseController extends controller
{
    public function index()
    {
        //
    }

    public function showPurchase(Request $request, $category, $title)
    {
        $tickets = explode(',' , $request->tickets);
        $numbers = explode(',' , $request->numbers);

        $url = str_replace('purchase', 'activity', $request->url());

        if ( !current($numbers) && count($numbers) == 1 ) {
            Session::flash('message', '請勾選票卷與數量');
            return Redirect::to($url);
        } elseif ( count($numbers) != count($tickets) ) {
            Session::flash('message', '票卷數目與種類不相符合');
            return Redirect::to($url);
        } elseif ( max(array_values($numbers)) > 10 ) {
            Session::flash('message', '請勿擅自修改票卷數目');
            return Redirect::to($url);
        }

        $purchase = array();
        foreach ($tickets as $key => $ticket_id) {
            $temp = array( 'id' => $ticket_id, 'wanted' => $numbers[$key] );
            array_push($purchase, $temp);
        }

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

        if (empty($activity)) {
            Session::flash('message', '查無無此活動票卷');
            return Redirect::to($url);
        } else {
            $tickets  = DB::table('act_tickets')
                         ->whereIn('id', $tickets )
                         ->where('activity_id', $activity->id)
                        //  ->where('left_over', '>', 0)
                         ->select(array(
                             'id', 'name',   'left_over',  'price', 'location',
                             'ticket_start', 'ticket_end', 'description',
                         ))
                         ->get();

            $weekday   = ['日', '一', '二', '三', '四', '五', '六'];
            $eventData = array();
            $misCatch  = array();
            foreach ($tickets as $ticket) {
                foreach ($purchase as $target) {
                    if ($ticket->id != $target['id']) {
                        continue;
                    } else {
                        if ($target['wanted'] > $ticket->left_over) {
                            array_push($misCatch, $ticket->id);
                        } else {
                            $weekday_start  = $weekday[date('w', strtotime($ticket->ticket_start))];
                            $weekday_end    = $weekday[date('w', strtotime($ticket->ticket_end))];
                            $data = (object) array (
                                        'id'        => $ticket->id,
                                        'name'      => $ticket->name,
                                        'price'     => $ticket->price,
                                        'quantity'  => $target['wanted'],
                                        'act_start' => preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket->ticket_start),
                                        'act_end'   => preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket->ticket_end),
                                    );
                            array_push($eventData, $data);
                        }
                    }
                }
            }

            if (!empty($misCatch)) {
                Session::flash('message', '目前剩餘票卷無法滿足您的需求');
                return Redirect::to($url);
            }
            return view('activity.purchase', compact('activity', 'eventData'));
        }
    }

    public function postPurchase(Request $request, $category, $title)
    {
        $data        = json_decode($request->data);

        $ticket_ids  = explode(',' , $data->tickets);
        $numbers     = explode(',' , $data->numbers);

        $url         = str_replace('purchase', 'activity', $request->url());

        $total_price = 0;
        $misCatch    = array();
        $purchase    = array();

        foreach ($ticket_ids as $key => $ticket_id) {
            $temp    = array( 'id' => $ticket_id, 'wanted' => $numbers[$key] );
            array_push($purchase, $temp);
        }

        $activity    = DB::table('activities')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->where('categories.name', $category)
                      ->where('activities.title', $title)
                      ->select(array(
                        'activities.id' ,               'activities.title',           'activities.thumbnail',         'activities.description',     'activities.activity_start',  'activities.activity_end',
                        'activities.category_id',       'activities.remark',          'activities.time_range',
                        'categories.name as category',  'activities.description',     'activities.hoster_id',
                      ))
                      ->where('activities.status', '>=', '2')
                      ->first();

        $tickets  = DB::table('act_tickets')
                     ->whereIn('id', $ticket_ids )
                     ->select(array(
                         'id', 'name',   'left_over',  'price', 'location',
                         'ticket_start', 'ticket_end', 'description',
                     ))
                     ->get();
        $total_price = 0;
        $itemDesc = ' [ ' . $activity->title . ' ] ';
        foreach ($tickets as $ticket) {
           foreach ($purchase as $target) {
                if ($ticket->id != $target['id']) {
                    continue;
                } else {
                    if ($target['wanted'] > $ticket->left_over) {
                        array_push($misCatch, $ticket->id);
                    } else {
                        $itemDesc .= $ticket->name . ' x ' . $target['wanted'] . '張； ';
                        $total_price += $ticket->price * $target['wanted'];
                    }
                }
            }
        }

        if (empty($activity)) {
            Session::flash('message', '查無無此活動票卷');
            return Redirect::to($url);
        } elseif (!empty($misCatch)) {
            Session::flash('message', '目前剩餘票卷無法滿足您的需求');
            return Redirect::to($url);
        } elseif ($total_price != $request->price) {
            Session::flash('message', '票卷金額異常，請重新購買');
            return Redirect::to($url);
        } else {
            // Mail::send('auth.emails.verify', array('confirmation_code'=>$confirmation_code), function($message) {
            //     $message->from('service@514.com.tw', '514 活動頻道');
            //     $message->to(Input::get('email'), Input::get('name'))
            //         ->subject('Verify your email address');
            // });

            foreach ($ticket_ids as $key => $id) {
                DB::table('act_tickets')->where('id', $id)->decrement('decrement', $numbers[$key]);
            }

            if ($total_price == 0) {
                $MerchantOrderNo = time();
                $storeOrder = array(
                                'MerchantOrderNo' => $MerchantOrderNo,
                                'TotalPrice'      => 0,
                                'ItemDesc'        => $itemDesc,
                                'user_id'         => Auth::id(),
                                'user_email'      => $request->email,
                                'user_phone'      => $request->mobile,
                                'hoster_id'       => $activity->hoster_id,
                                'activity_id'     => $activity->id,
                                'activity_name'   => $title,
                                'ticket_id'       => $data->tickets,
                                'ticket_number'   => $data->numbers,
                                'ticket_price'    => $total_price,
                                'created_at'      => date("Y-m-d H:i:s"),
                                'PayTime'         => date("Y-m-d H:i:s"),
                              );
                $insertOrder = DB::table('orders')->insert($storeOrder);

                $order = (object) array(
                    'MerchantOrderNo' => $MerchantOrderNo,
                    'TradeNo'    => str_random(30),
                    'TradeTime'  => date("Y-m-d H:i:s"),
                    'TotalPrice' => 0,
                );
                $tickets = $this->successOrder($order);
                return Redirect::to('purchase/'.$order->MerchantOrderNo);
            } else {

                $Pay2go     = new Pay2go();
                $merID      = env('Pay2go_ID',  11606075);
                $merKey     = env('Pay2go_Key', "7CPtmx1zm86jpLfWndymKbPmlyqP7oye");
                $merIV      = env('Pay2go_IV',  "1oInVJXhR3BhOQeb");
                $autoSubmit = TRUE;
                $title      = urldecode($request->segment(3));
                $result     = array (
                                    "MerchantID"        =>  $merID,                 //	商店代號
                                    "RespondType"	      =>  "JSON",                 //  回傳格式
                                    "TimeStamp"		      =>  time(),                 //	時間戳記
                                    "Version"		        =>  "1.1",                  //	串接版本
                                    "MerchantOrderNo"	  =>  date("Ymdhis", time()), //	商店訂單編號
                                    "Amt"		            =>  $total_price,           //	訂單金額
                                    "ItemDesc"		      =>  $itemDesc,              //	商品資訊
                                    "LoginType"		      =>  "0",                    //	是否要登入智付寶會員
                                    'Email'             =>  $request->email,
                                    // 'OrderComment'      =>  $ticket->remark,
                                    'TradeLimit'        =>  300,
                                    'ReturnURL'         =>  url('purchase/result'),
                                );

                $result["CheckValue"]	= $Pay2go->get_check_value($result, $merKey, $merIV);
                $submitButtonStyle    = "<input id='Pay2goMgr' name='submit' type='submit' value='送出' />";

                $storeOrder = array(
                                'MerchantID'      => $merID,
                                'MerchantOrderNo' => $result['MerchantOrderNo'],
                                'TotalPrice'      => $result['Amt'],
                                'ItemDesc'        => $result['ItemDesc'],
                                // 'OrderComment'    => $result['OrderComment'],
                                'user_id'         => Auth::id(),
                                'user_email'      => $request->email,
                                'user_phone'      => $request->mobile,
                                'hoster_id'       => $activity->hoster_id,
                                'activity_id'     => $activity->id,
                                'activity_name'   => $activity->title,
                                'ticket_id'       => $data->tickets,
                                'ticket_price'    => $total_price,
                                'ticket_number'   => $data->numbers,
                                'created_at'      => date("Y-m-d H:i:s"),
                              );

                DB::table('orders')->insert($storeOrder);
                return $Pay2go->create_form($result, NULL, TRUE, $autoSubmit, 0, $submitButtonStyle);
            }
        }
    }

    public function postByPay2Go(Request $request)
    {
        $result = (object) json_decode($request->Result,true);
        if( $request->Status != "SUCCESS" ) {
            $updateArray = array(
              'status' => 2,
            );

            $order = DB::table('orders')->where('MerchantOrderNo', $result->MerchantOrderNo);
            $order->update($updateArray);

            $ticket_ids  = explode(',' , $order->first()->ticket_id);
            $numbers     = explode(',' , $order->first()->ticket_numbers);

            foreach ($ticket_ids as $key => $id) {
                DB::table('act_tickets')->where('id', $id)->increment('decrement', $numbers[$key]);
            }
            return Redirect::to(Session::get('url'));

        } else {
            $updateArray = array(
                'TradeNo'         => $result->TradeNo,
                'MerchantOrderNo' => $result->MerchantOrderNo,
                'CheckCode'       => $result->CheckCode,
                'EscrowBank'      => $result->EscrowBank,
                'Card6No'         => $result->Card6No,
                'Card4No'         => $result->Card4No,
                'InstFirst'       => $result->InstFirst,
                'InstEach'        => $result->InstEach,
                'Inst'            => $result->Inst,
                'IP'              => $result->IP,
                'PayTime'         => $result->PayTime,
                'status'          => 1,
                'OrderResult'     => json_encode($result),
                'updated_at'      => date("Y-m-d H:i:s"),
            );
            DB::table('orders')->where('MerchantOrderNo', $result->MerchantOrderNo)->update($updateArray);

            $order = (object) array(
                'MerchantOrderNo' => $result->MerchantOrderNo,
                'TradeNo'    => $result->TradeNo,
                'TradeTime'  => date("Y-m-d H:i:s"),
                'TotalPrice' => $result->Inst,
            );
            $tickets = $this->successOrder($order);
            return Redirect::to('purchase/'.$result->MerchantOrderNo);
        }
    }

    private function successOrder($order)
    {
        $info = DB::table('orders')
                  ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                  ->rightJoin('activities',  'orders.activity_id', '=', 'activities.id')
                  ->select(array(
                      'orders.id', 'orders.user_name', 'orders.user_email', 'orders.user_phone', 'orders.ticket_number', 'orders.TotalPrice',
                      'orders.PayTime',   'activities.title as activity_name',      'activities.location as activity_location', 'orders.ticket_id',
                  ))
                  ->where('MerchantOrderNo', $order->MerchantOrderNo)
                  ->first();

        DB::table('orders')->where('id', $info->id)->increment('status');

        $ticket_ids     = explode(',' , $info->ticket_id);
        $ticket_numbers = explode(',' , $info->ticket_number);

        $ticket_infos = array();
        foreach ($ticket_ids as $key => $id) {
            $ticket_target = DB::table('act_tickets')
                              ->where('id', $id)
                              ->select(array(
                                'id', 'name', 'price', 'ticket_start', 'ticket_end'
                              ))->first();
            $weekday   = ['日', '一', '二', '三', '四', '五', '六'];
            $weekday_start  = $weekday[date('w', strtotime($ticket_target->ticket_start))];
            $weekday_end    = $weekday[date('w', strtotime($ticket_target->ticket_end))];
            $ticket_target->ticket_start = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket_target->ticket_start);
            $ticket_target->ticket_end   = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket_target->ticket_end);
            $ticket_target->quantity     = $ticket_numbers["$key"];
            array_push($ticket_infos, $ticket_target);
        }

        $orders = (object) array(
            'TradeNo'           => $order->TradeNo,
            'TradeTime'         => $order->TradeTime,
            'TotalPrice'        => $order->TotalPrice,
            'user_name'         => $info->user_name,
            'user_phone'        => $info->user_phone,
            'user_email'        => $info->user_email,
            'activity_name'     => $info->activity_name,
            'activity_location' => $info->activity_location,
            'ticket_infos'      => $ticket_infos,
        );

        Mail::send('activity.confirm_mail', array('tickets' => $orders), function($message) use ($info) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to( Auth::user()->email, $info->user_name )
                    ->subject('【 514 活動頻道 】恭喜您！您的活動行程已經訂購成功！');
        });

        return $orders;
    }

    public function getTradeInfo($id) {
        $orders = DB::table('orders')
                    ->leftJoin('activities',  'orders.activity_id', '=', 'activities.id')
                    ->where('MerchantOrderNo', $id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (empty($orders)) {
            return Redirect::to('');
        }
        $ticket_ids     = explode(',' , $orders->ticket_id);
        $ticket_numbers = explode(',' , $orders->ticket_number);
        $ticket_infos   = array();
        foreach ($ticket_ids as $key => $id) {
            $ticket_target = DB::table('act_tickets')
                              ->where('id', $id)
                              ->select(array(
                                'id', 'name', 'price', 'ticket_start', 'ticket_end'
                              ))->first();
            $weekday   = ['日', '一', '二', '三', '四', '五', '六'];
            $weekday_start  = $weekday[date('w', strtotime($ticket_target->ticket_start))];
            $weekday_end    = $weekday[date('w', strtotime($ticket_target->ticket_end))];
            $ticket_target->ticket_start = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket_target->ticket_start);
            $ticket_target->ticket_end   = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket_target->ticket_end);
            $ticket_target->quantity     = $ticket_numbers["$key"];
            array_push($ticket_infos, $ticket_target);
        }

        $tickets = (object) array(
            'TradeNo'           => $orders->MerchantOrderNo,
            'TradeTime'         => $orders->PayTime,
            'TotalPrice'        => $orders->TotalPrice,
            'user_name'         => $orders->user_name,
            'user_phone'        => $orders->user_phone,
            'user_email'        => $orders->user_email,
            'activity_name'     => $orders->activity_name,
            'activity_location' => $orders->location,
            'ticket_infos'      => $ticket_infos,
        );
        return view('activity.confirm', compact('tickets'));
    }
}
