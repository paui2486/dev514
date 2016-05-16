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

    public function showPurchase(Request $request, $id)
    {
        $tickets = explode(',' , $request->tickets);
        $numbers = explode(',' , $request->numbers);

        $url = str_replace('purchase', 'activity', $request->url());

        if ( !current($numbers) && count($numbers) == 1 ) {
            Session::flash('message', '請勾選您要的票券，謝謝!');
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
                      // ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                      // ->where('categories.name', $category)
                      ->where('activities.id', $id)
                      ->select(array(
                        'activities.id' ,             'activities.title',               'activities.thumbnail',
                        'activities.description',     'activities.activity_start',      'activities.activity_end',
                        'activities.category_id',     'activities.remark',              'activities.time_range',
                        'activities.location',        'categories.name as locat_name',  'activities.description',
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

    public function postPurchase(Request $request, $id)
    {
        // sample = {
        //     _token: "GkuQnkX0r2xUGFwKigEVLu3SOupjlYvZXlhMw243",
        //     name: "測試一",
        //     mobile: "091231231231",
        //     email: "123123@22.gg",
        //     data: "{"tickets":"34,35","numbers":"1,3"}",    step 1
        //     data: "{ id: { "tickets":"34","numbers":"1"} }",    step 2
        //     price: "55"
        // }
        Log::error(URL::current() . ' postPurchase()');
        Log::error($request);
        // return Input::all();
        $data        = json_decode($request->data);
        $ticket_ids  = explode(',' , $data->tickets);
        $numbers     = explode(',' , $data->numbers);

        // replace url activity -> purchase
        $url         = str_replace('purchase', 'activity', $request->url());
        $purchase    = array();

        foreach ($ticket_ids as $key => $ticket_id) {
            $temp    = array( 'id' => $ticket_id, 'wanted' => $numbers[$key] );
            array_push($purchase, $temp);
        }

        $activity    = DB::table('activities')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      // ->where('categories.name', $category)
                      ->where('activities.id', $id)
                      ->select(array(
                        'activities.id' ,               'activities.title',           'activities.thumbnail',         'activities.description',     'activities.activity_start',  'activities.activity_end',
                        'activities.category_id',       'activities.remark',          'activities.time_range',
                        'categories.name as category',  'activities.description',     'activities.hoster_id',
                      ))
                      ->where('activities.status', '=', '4')
                      ->first();

        $expireDate = date('Ymd', strtotime ( '+1 day') );

        $tickets  = DB::table('act_tickets')
                     ->whereIn('id', $ticket_ids )
                     ->select(array(
                         'id', 'name',   'left_over',  'price', 'location',
                         'ticket_start', 'ticket_end', 'description',
                     ))
                     ->get();

        $total_price = 0;
        $misCatch    = array();
        $itemDesc    = ' [ ' . $activity->title . ' ] ';
        foreach ($tickets as $ticket) {
           foreach ($purchase as $target) {
                if ($ticket->id != $target['id']) {
                    continue;
                } else {
                    if ($target['wanted'] > $ticket->left_over) {
                        array_push($misCatch, $ticket->id);
                        $misTarget = $ticket->name;
                    } else {
                        $itemDesc .= $ticket->name . ' x ' . $target['wanted'] . '張； ';
                        $total_price += $ticket->price * $target['wanted'];
                    }
                }
            }
        }

        if (empty($activity)) {
            Session::flash('message', '抱歉！查無無此活動票卷');
            return Redirect::to($url);
        } elseif (!empty($misCatch)) {
            Session::flash('message', '抱歉！目前 '. $misTarget .' 的剩餘票卷，無法滿足您的需求');
            return Redirect::to($url);
        } elseif ($total_price != $request->price) {
            Session::flash('message', '抱歉！您的票卷金額異常，請重新購買');
            return Redirect::to($url);
        } else {
            $MerchantOrderNo = date("Ymdhis", time());
            $user_id         = (Auth::check())? Auth::id() : '';
            $orderInfo            = (object) array(
                                    'ItemDesc'        => $itemDesc,
                                    'MerchantOrderNo' => $MerchantOrderNo,
                                    'TradeNo'         => str_random(30),
                                    'TradeTime'       => date("Y-m-d H:i:s"),
                                    'TotalPrice'      => $total_price,
                                    'ExpireDate'     => $expireDate,
                                    'activity'        => $activity,
                                    'data'            => $purchase,
                                    'total_price'     => $total_price,
                                    'user_id'         => $user_id,
                                    'user_name'       => $request->name,
                                    'user_email'      => $request->email,
                                    'user_phone'      => $request->mobile,
                                );

            $reduceResult = $this->reduceTickets($orderInfo);
            if (!$reduceResult) {
                Session::flash('message', '抱歉！目前 '. $misTarget .' 的剩餘票卷，無法滿足您的需求');
                return Redirect::to($url);
            } else {
                $insertResult = $this->insertOrderGetID($orderInfo);
            }

            if ($total_price == 0) {
                $orderResult = $this->successOrder($orderInfo);
                return Redirect::to('purchase/trade/'.$orderResult->MerchantOrderNo);
            } else {
                // go pay2go
                $Pay2go     = new Pay2go();
                $PayEnvDev  = (Auth::id() != env('DemoID', 1))? env('Pay2go_DEV', TRUE) : TRUE;
                $merID      = (!$PayEnvDev) ? env('Pay2go_ID') : 11606075 ;
                $merKey     = (!$PayEnvDev) ? env('Pay2go_Key'): "7CPtmx1zm86jpLfWndymKbPmlyqP7oye";
                $merIV      = (!$PayEnvDev) ? env('Pay2go_IV') : "1oInVJXhR3BhOQeb";
                $payVersion = env('Pay2go_Version', "1.1");
                $autoSubmit = TRUE;
                $result     = array (
                                    "MerchantID"        =>  $merID,                 //	商店代號
                                    "RespondType"	      =>  "JSON",                 //  回傳格式
                                    "TimeStamp"		      =>  time(),                 //	時間戳記
                                    "Version"		        =>  $payVersion,                  //	串接版本
                                    "MerchantOrderNo"	  =>  $orderInfo->MerchantOrderNo, //	商店訂單編號
                                    "Amt"		            =>  $orderInfo->TotalPrice,           //	訂單金額
                                    "ItemDesc"		      =>  $orderInfo->ItemDesc,              //	商品資訊
                                    "LoginType"		      =>  "0",                    //	是否要登入智付寶會員
                                    'Email'             =>  $request->email,
                                    'TradeLimit'        =>  900,                    //  交易秒數
                                    'ExpireDate'        =>  $expireDate, // 需要修改
                                    'ReturnURL'         =>  url('purchase/result'), // must be different
                                    'NotifyURL'         =>  url('purchase/notify'),
                                    // 'ClientBackURL'     =>  URL::current(),
                                );

                $result["CheckValue"]	= $Pay2go->get_check_value($result, $merKey, $merIV);
                $submitButtonStyle    = "<input id='Pay2goMgr' name='submit' type='submit' value='送出' />";
                return $Pay2go->create_form($result, NULL, $PayEnvDev, $autoSubmit, 0, $submitButtonStyle);
            }
        }
    }

    public function pay2GoResult(Request $request)
    {
        // no matter success or fail
          // $return = array (
          //   'Status' => 'TRA10016',
          //   'Message' => '信用卡授權失敗拒絕交易',
          //   'Result' => '{
          //       "MerchantID":"37455317", "Amt":300,  "TradeNo": "16051417122853204",
          //       "MerchantOrderNo":"20160514050952",  "RespondType":"JSON",
          //       "CheckCode":"32DD623B49F29268F78634971BD660CDCD60B490CE46AFE463B766A64519DACB",
          //       "IP":"111.248.55.187",  "EscrowBank":"-",
          //       "ItemDesc":"[ \\u6e2c\\u8a66\\u6d3b\\u52d5 ] \\u65e9\\u9ce5\\u7968 x 2\\u5f35\\uff1b \\u5c0f\\u7968 x 1\\u5f35\\uff1b",
          //       "IsLogin":false,  "PaymentType":"CREDIT",
          //       "PayTime":"2016-05-14 17:12:39",  "RespondCode":"05","Auth":"",
          //       "Card6No":"400022","Card4No":"2222","Exp":"1802",
          //       "TokenUseStatus":0,"InstFirst":0,"InstEach":0,
          //       "Inst":0,"ECI":null}',
          // )
        Log::error(URL::current() . ' pay2GoResult()');
        Log::error(Input::all());
        // url 2 notify or result
        $comURL     = urldecode($request->segment(2));
        $status     = $request->Status;
        $msg        = $request->Message;

        if ($comURL == 'result') {
          $feedback   = (object) json_decode($request->Result, true);
        } else {
          $feedback   = (object) json_decode($request->JSONData, true);
        }

        $feedback   = (object) json_decode($request->Result, true);
        $order      = DB::table('orders')->where('MerchantOrderNo', $feedback->MerchantOrderNo)->first();

        if ( $status == "SUCCESS" ) {
            // parse type
            switch ($feedback->PaymentType) {
                case 'CREDIT':
                    // $comURL = result
                    $updateArray = array(
                        'MerchantID'      => $feedback->MerchantID,
                        'TradeNo'         => $feedback->TradeNo,
                        'MerchantOrderNo' => $feedback->MerchantOrderNo,
                        'CheckCode'       => $feedback->CheckCode,
                        'EscrowBank'      => $feedback->EscrowBank,
                        'IP'              => $feedback->IP,
                        'PayTime'         => $feedback->PayTime,

                        'Card6No'         => $feedback->Card6No,
                        'Card4No'         => $feedback->Card4No,
                        'InstFirst'       => $feedback->InstFirst,
                        'InstEach'        => $feedback->InstEach,
                        'Inst'            => $feedback->Inst,
                        'status'          => 2,
                        'OrderComment'    => 'CREDIT: ' . $feedback->RespondCode . '; Amt: ' . $feedback->Amt . ' - ' . $msg,
                        'OrderResult'     => json_encode($feedback),
                        'updated_at'      => date("Y-m-d H:i:s"),
                    );

                    DB::table('orders_detail')
                        ->where('order_id', $order->id)
                        ->update(array(
                            'status' => 1
                        ));
                    Log::error('WTF! CREDIT payment type');
                    break;

                case 'WEBATM':
                    // $comURL = notify
                    Log::error('WTF! WEBATM payment type');
                    $updateArray = array(
                        'MerchantID'      => $feedback->MerchantID,
                        'TradeNo'         => $feedback->TradeNo,
                        'MerchantOrderNo' => $feedback->MerchantOrderNo,
                        'CheckCode'       => $feedback->CheckCode,
                        'EscrowBank'      => $feedback->EscrowBank,
                        'IP'              => $feedback->IP,
                        'PayTime'         => $feedback->PayTime,
                        'status'          => 2,
                        'OrderResult'     => json_encode($feedback),
                        'OrderComment'    => 'WEBATM: ' . $feedback->PayBankCode . '; Amt: ' . $feedback->Amt . ' - ' . $msg,
                        'updated_at'      => date("Y-m-d H:i:s"),
                    );

                    DB::table('orders_detail')
                        ->where('order_id', $order->id)
                        ->update(array(
                            'status' => 1
                        ));
                    break;

                case 'VACC':
                    // $comURL = notify
                    Log::error('WTF! VACC payment type');
                    $updateArray = array(
                        'MerchantID'      => $feedback->MerchantID,
                        'TradeNo'         => $feedback->TradeNo,
                        'MerchantOrderNo' => $feedback->MerchantOrderNo,
                        'CheckCode'       => $feedback->CheckCode,
                        'EscrowBank'      => $feedback->EscrowBank,
                        'IP'              => $feedback->IP,
                        'PayTime'         => $feedback->PayTime,
                        'status'          => 2,
                        'OrderResult'     => json_encode($feedback),
                        'OrderComment'    => 'VACC: ' . $feedback->PayBankCode . '; Amt: ' . $feedback->Amt . ' - ' . $msg,
                        'updated_at'      => date("Y-m-d H:i:s"),
                    );

                    DB::table('orders_detail')
                        ->where('order_id', $order->id)
                        ->update(array(
                            'status' => 1
                        ));
                    break;

                case 'CVS':
                    // $comURL = notify
                    Log::error('WTF! CVS payment type');
                    $updateArray = array(
                        'MerchantID'      => $feedback->MerchantID,
                        'TradeNo'         => $feedback->TradeNo,
                        'MerchantOrderNo' => $feedback->MerchantOrderNo,
                        'CheckCode'       => $feedback->CheckCode,
                        'EscrowBank'      => $feedback->EscrowBank,
                        'IP'              => $feedback->IP,
                        'PayTime'         => $feedback->PayTime,
                        'status'          => 2,
                        'OrderResult'     => json_encode($feedback),
                        'OrderComment'    => 'CVS: Amt: ' . $feedback->Amt . ' - ' . $msg,
                        'updated_at'      => date("Y-m-d H:i:s"),
                    );

                    DB::table('orders_detail')
                        ->where('order_id', $order->id)
                        ->update(array(
                            'status' => 1
                        ));
                    break;

                case 'BARCODE':
                    // $comURL = notify
                    Log::error('WTF! BARCODE payment type');
                    Log::error(Input::all());
                    $updateArray = array(
                        'MerchantID'      => $feedback->MerchantID,
                        'TradeNo'         => $feedback->TradeNo,
                        'MerchantOrderNo' => $feedback->MerchantOrderNo,
                        'CheckCode'       => $feedback->CheckCode,
                        'EscrowBank'      => $feedback->EscrowBank,
                        'IP'              => $feedback->IP,
                        'PayTime'         => $feedback->PayTime,
                        'status'          => 2,
                        'OrderResult'     => json_encode($feedback),
                        'OrderComment'    => 'BARCODE: Amt: ' . $feedback->Amt . ' - ' . $msg,
                        'updated_at'      => date("Y-m-d H:i:s"),
                    );

                    DB::table('orders_detail')
                        ->where('order_id', $order->id)
                        ->update(array(
                            'status' => 1
                        ));
                    break;

                default:
                    // $comURL = ?
                    Log::error('WTF! CUSTOME payment type');
                    Log::error(Input::all());
                    exit;
                    break;
            }

            $ticket_infos = array();
            $ticket_ids     = DB::table('orders_detail')
                ->where('order_id', $order->id)
                ->orderBy('id', 'ASC')->lists('sub_topic_id');
            $ticket_numbers = DB::table('orders_detail')
                ->where('order_id', $order->id)
                ->orderBy('id', 'ASC')->lists('sub_topic_number');

            $ticket_infos = array();
            foreach ($ticket_ids as $key => $id) {
                $ticket_target = DB::table('act_tickets')
                                  ->where('id', $id)
                                  ->select(array(
                                    'id', 'name', 'price', 'ticket_start', 'ticket_end', 'activity_id'
                                  ))->first();
                $weekday   = ['日', '一', '二', '三', '四', '五', '六'];
                $weekday_start  = $weekday[date('w', strtotime($ticket_target->ticket_start))];
                $weekday_end    = $weekday[date('w', strtotime($ticket_target->ticket_end))];
                $ticket_target->ticket_start = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket_target->ticket_start);
                $ticket_target->ticket_end   = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket_target->ticket_end);
                $ticket_target->quantity     = $ticket_numbers["$key"];
                array_push($ticket_infos, $ticket_target);
            }

            $act = DB::table('activities')->find( DB::table('orders_detail')->where('order_id', $order->id)->first()->topic_id );
            $tickets = (object) array(
                'TradeNo'           => $feedback->TradeNo,
                'TradeTime'         => $feedback->PayTime,
                'TotalPrice'        => $feedback->Amt,
                'MerchantOrderNo'   => $feedback->MerchantOrderNo,
                'ItemDesc'          => $feedback->ItemDesc,
                'user_name'         => $order->user_name,
                'user_phone'        => $order->user_phone,
                'user_email'        => $order->user_email,
                'activity_name'     => $act->title,
                'activity_location' => $act->location,
                'ticket_infos'      => $ticket_infos,
            );

            DB::table('orders')->where('MerchantOrderNo', $feedback->MerchantOrderNo)->update($updateArray);

            $hoster = DB::table('users')->find($act->hoster_id);

            // email provider
            $msg = '<p>'. $hoster->name .'您好，</p>
                        <p>' . $tickets->user_name . '已訂購『' . $tickets->ItemDesc .'』，請登入後台查詢名單，即可獲得更多資訊。謝謝！</p>
                        <p>後台連結：<a href="'. url('dashboard/activity/' .$ticket_target->activity_id. '/tickets/admission') .'">後台活動票券名單</a>';
            Mail::send('auth.emails.checkout', array('msg' => $msg),  function($message) use ($tickets, $hoster, $msg) {
                $message->from('service@514.com.tw', '514 活動頻道');
                $message->to( $hoster->email, $hoster->name )
                      ->subject('【514活動報名通知】活動主您好，'. $tickets->user_name .' 已於『'. $tickets->ItemDesc .'』完成報名');
            });

            // MSG  customer
            $subject_msg = "【514生活頻道】感謝您報名了活動名稱，前往查看：票券連結。 ". url('purchase/trade/'.$feedback->MerchantOrderNo);
            $msg  = "username=coevo5311&password=coevo8909&dstaddr=". $tickets->user_phone ."&smbody=". $subject_msg;
            $host = "202.39.48.216";
            $url  = "http://".$host."/kotsmsapi-1.php?".$msg;
            $ch   = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $html = curl_exec($ch);
            Log::error($html);
            curl_close($ch);

            // email customer
            Mail::send('activity.confirm_mail', array('tickets' => $tickets), function($message) use ($tickets, $hoster) {
                $message->from('service@514.com.tw', '514 活動頻道');
                $message->to( $tickets->user_email, $tickets->user_name )
                        // ->bcc( $hoster->email, $hoster->name )
                        ->subject('【514活動報名通知】您好'. $tickets->user_name .'，您已經成功報名『'. $tickets->ItemDesc .'』');
            });

            // return Response::json($feedback);
            return Redirect::to('purchase/trade/'.$feedback->MerchantOrderNo);
        } else {
            $order_info = DB::table('orders')
                            ->leftJoin('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
                            ->select(array(
                                'orders.id as order_id', 'orders_detail.topic_id as activity_id',
                                'orders_detail.sub_topic_id as ticket_id', 'orders_detail.sub_topic_number as ticket_number',
                            ))
                            ->where('orders.MerchantOrderNo', $feedback->MerchantOrderNo)
                            ->get();

            // Log::error(json_encode($order_info));
            $first_order = reset($order_info);
            $url = URL('activity/' . $first_order->activity_id);

            // clean order
            if ($status == "TRA10016") { // 信用卡授權失敗拒絕交易
                DB::table('orders')->where('MerchantOrderNo', $feedback->MerchantOrderNo)
                      ->update(array(
                          'TradeNo'         => $feedback->TradeNo,
                          'CheckCode'       => $feedback->CheckCode,
                          'EscrowBank'      => $feedback->EscrowBank,
                          'Card6No'         => $feedback->Card6No,  // not sure
                          'Card4No'         => $feedback->Card4No,  // not sure
                          'InstFirst'       => $feedback->InstFirst,
                          'InstEach'        => $feedback->InstEach,
                          'Inst'            => $feedback->Inst,
                          'IP'              => $feedback->IP,
                          'PayTime'         => $feedback->PayTime,
                          'OrderComment'    => $feedback->RespondCode . ' - ' . $msg,
                          'OrderResult'     => json_encode($feedback),
                          'status'          => 1,
                          'updated_at'      => date("Y-m-d H:i:s"),
                      ));
            } else {
                DB::table('orders')->where('MerchantOrderNo', $feedback->MerchantOrderNo)
                      ->update(array(
                        'status'          => 1,
                        'updated_at'      => date("Y-m-d H:i:s"),
                      ));
            }

            // clean orders_detail and turn back ticket
            DB::table('orders_detail')->where('order_id', $first_order->order_id)
                  ->update(array(
                      'status' => 3,
                  ));

            foreach ($order_info as $order) {
                $turnback = $order->ticket_number;
                DB::table('act_tickets')->where('id', $order->ticket_id)
                  ->update(array(
                    'left_over'     => DB::raw("left_over + $turnback"),
                    'ticket_start'  => DB::raw('ticket_start'),
                  ));
            }

            Session::flash('message', $msg);
            return Redirect::to($url);
        }
    }

    public function pay2GoNotify(Request $request)
    {
        Log::error(URL::current() . ' pay2GoNotify()');
        Log::error(Input::all());
        $feedback   = (object) json_decode($request->JSONData, true);
        Log::error(json_encode($feedback));
    }

    private function reduceTickets($info)
    {
        try {
            $orders_tickets     = $info->data;
            foreach ($orders_tickets as $want) {
                $wanted         = $want['wanted'];
                $want['reduce'] = DB::table('act_tickets')->where('id', $want['id'])
                    ->update(array(
                        'left_over'    => DB::raw("left_over - $wanted"),
                        'ticket_start' => DB::raw('ticket_start'),
                    ));
            }
            return true;
        } catch ( Exception $e ) {
            Log::error('Caught exception: ',  $e->getMessage(), "\n");
            return false;
        }
    }

    private function insertOrderGetID($info)
    {
        $insertInfo = array(
            'MerchantOrderNo' => $info->MerchantOrderNo,
            'TotalPrice'      => $info->total_price,
            'ItemDesc'        => $info->ItemDesc,
            'ExpireDate'      => $info->ExpireDate,
            'user_id'         => $info->user_id,
            'user_name'       => $info->user_name,
            'user_email'      => $info->user_email,
            'user_phone'      => $info->user_phone,
            'created_at'      => date("Y-m-d H:i:s"),
        );

        $info->orderID = DB::table('orders')->insertGetId($insertInfo);
        $resultInfo    = $this->insertTicketToOrder($info);

        return $resultInfo;
    }

    private function insertTicketToOrder($info)
    {
        try {
            // Log::error(json_encode($info));
            $orders_tickets     = $info->data;
            foreach ($orders_tickets as $want) {
                $ticket = DB::table('act_tickets')->find($want['id']);
                $status = ($ticket->price == 0) ? 1 : 0;
                $orderDetail = array(
                                'order_id'      => $info->orderID,
                                'topic_type'    => 1, // activty, coupon, stock.....
                                'topic_id'      => $info->activity->id,
                                'topic_name'    => $info->activity->title,
                                'provider_id'   => $info->activity->hoster_id,
                                'sub_topic_id'  => $ticket->id,
                                'sub_topic_name'    => $ticket->name,
                                'sub_topic_price'   => $ticket->price,
                                'sub_topic_number'  => $want['wanted'],
                                'status'        => $status, // 因為免費所以直接結清
                                'owner_id'      => $info->user_id,
                                'owner_name'    => $info->user_name,
                                'owner_email'   => $info->user_email,
                              );
                $want['insertResult'] = DB::table('orders_detail')->insert($orderDetail);
            }
            return true;
        } catch ( Exception $e ) {
            Log::error('Caught exception: ',  $e->getMessage(), "\n");
            return false;
        }
    }

    private function successOrder($order)
    {
        $info = DB::table('orders')
                  ->select(array(
                      'id',        'PayTime',    'TotalPrice',
                      'user_name', 'user_phone', 'user_email', 'ItemDesc'
                  ))
                  ->where('MerchantOrderNo', $order->MerchantOrderNo)
                  ->first();


                  // paytime 還要思考
        $paytime = date("Y-m-d H:i:s");

        $updateOrder       = DB::table('orders')->where('id', $info->id)
                              ->update(array(
                                  'status'     => 2,
                                  'PayTime'    => $paytime,
                                  'updated_at' => date("Y-m-d H:i:s"),
                                ));
        $orderDetail       = DB::table('orders_detail')->where('order_id', $info->id);
        $updateOrderDetail = $orderDetail->update(array('status' => 1));

        $ticket_ids     = $orderDetail->orderBy('id', 'ASC')->lists('sub_topic_id');
        $ticket_numbers = $orderDetail->orderBy('id', 'ASC')->lists('sub_topic_number');

        $ticket_infos = array();
        foreach ($ticket_ids as $key => $id) {
            $ticket_target = DB::table('act_tickets')
                              ->where('id', $id)
                              ->select(array(
                                'id', 'name', 'price', 'ticket_start', 'ticket_end', 'activity_id'
                              ))->first();
            $weekday   = ['日', '一', '二', '三', '四', '五', '六'];
            $weekday_start  = $weekday[date('w', strtotime($ticket_target->ticket_start))];
            $weekday_end    = $weekday[date('w', strtotime($ticket_target->ticket_end))];
            $ticket_target->ticket_start = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket_target->ticket_start);
            $ticket_target->ticket_end   = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket_target->ticket_end);
            $ticket_target->quantity     = $ticket_numbers["$key"];
            array_push($ticket_infos, $ticket_target);
        }

        $act = DB::table('activities')->find( $orderDetail->first()->topic_id );
        $orders = (object) array(
            'TradeNo'           => $order->TradeNo,
            'TradeTime'         => $order->TradeTime,
            'TotalPrice'        => $order->TotalPrice,
            'ItemDesc'          => $order->ItemDesc,
            'MerchantOrderNo'   => $order->MerchantOrderNo,
            'user_name'         => $info->user_name,
            'user_phone'        => $info->user_phone,
            'user_email'        => $info->user_email,
            'activity_name'     => $act->title,
            'activity_location' => $act->location,
            'ticket_infos'      => $ticket_infos,
        );
        $hoster = DB::table('users')->find($act->hoster_id);

        // email provider
        $msg = '<p>'. $hoster->name .'您好，</p>
                    <p>' . $info->user_name . '已訂購『' . $info->ItemDesc .'』，請登入後台查詢名單，即可獲得更多資訊。謝謝！</p>
                    <p>後台連結：<a href="'. url('dashboard/activity/' .$ticket_target->activity_id. '/tickets/admission') .'">後台活動票券名單</a>';
        Mail::send('auth.emails.checkout', array('msg' => $msg),  function($message) use ($info, $hoster, $msg) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to( $hoster->email, $hoster->name )
                  ->subject('【514活動報名通知】活動主您好，'. $info->user_name .' 已於『'. $info->ItemDesc .'』完成報名');
        });

        // MSG  customer
        $subject_msg = "【514生活頻道】感謝您報名了活動名稱，前往查看：票券連結。";
        $msg  = "username=coevo5311&password=coevo8909&dstaddr=". $info->user_phone ."&smbody=". $subject_msg;
        $host = "202.39.48.216";
        $url  = "http://".$host."/kotsmsapi-1.php?".$msg;
        $ch   = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);
        curl_close($ch);

        // email customer
        Mail::send('activity.confirm_mail', array('tickets' => $orders), function($message) use ($info, $hoster) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to( $info->user_email, $info->user_name )
                    // ->bcc( $hoster->email, $hoster->name )
                    ->subject('【514活動報名通知】'. $info->user_name .'您好，您已經成功報名『'. $info->ItemDesc .'』
');
        });

        return $orders;
    }

    public function getTradeInfo($id) {
        $orders = DB::table('orders')
                    ->select(array(
                        'orders.id', 'orders.MerchantOrderNo', 'orders.PayTime',         'orders.TotalPrice',
                        'orders.user_name',       'orders.user_phone',      'orders.user_email',
                    ))
                    ->where('MerchantOrderNo', $id)
                    ->where('status', 2)
                    // ->where('user_id', Auth::id())
                    ->first();

        if (empty($orders)) {
            return Redirect::to('');
        }

        $orderDetail       = DB::table('orders_detail')->where('order_id', $orders->id);
        $ticket_ids     = $orderDetail->orderBy('id', 'ASC')->lists('sub_topic_id');
        $ticket_numbers = $orderDetail->orderBy('id', 'ASC')->lists('sub_topic_number');

        $ticket_infos   = array();
        foreach ($ticket_ids as $key => $id) {
            $ticket_target = DB::table('act_tickets')
                                ->where('id', $id)
                                ->select(array(
                                  'id', 'name', 'price', 'ticket_start', 'ticket_end'
                                ))
                                ->first();
            $weekday   = ['日', '一', '二', '三', '四', '五', '六'];
            $weekday_start  = $weekday[date('w', strtotime($ticket_target->ticket_start))];
            $weekday_end    = $weekday[date('w', strtotime($ticket_target->ticket_end))];
            $ticket_target->ticket_start = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket_target->ticket_start);
            $ticket_target->ticket_end   = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket_target->ticket_end);
            $ticket_target->quantity     = $ticket_numbers["$key"];
            array_push($ticket_infos, $ticket_target);
        }

        $act = DB::table('activities')
                ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                ->where( 'activities.id', $orderDetail->first()->topic_id )->first();

        $tickets = (object) array(
            'TradeNo'           => $orders->MerchantOrderNo,
            'TradeTime'         => $orders->PayTime,
            'TotalPrice'        => $orders->TotalPrice,
            'user_name'         => $orders->user_name,
            'user_phone'        => $orders->user_phone,
            'user_email'        => $orders->user_email,
            'activity_name'     => $act->title,
            'activity_locaname' => $act->name,
            'activity_location' => $act->location,
            'ticket_infos'      => $ticket_infos,
        );
        return view('activity.confirm', compact('tickets'));
    }
}
