<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Input;
use Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    //
    public function index()
    {
    }

    public function HostGuide()
    {
        return view("page.host-guide");
    }

    public function About()
    {
        return view("page.about");
    }

    public function Joinus()
    {
        return view("page.joinus");
    }

    public function Advertising()
    {
        return view("page.advertising");
    }

    public function Privacy()
    {
        return view("page.privacy");
    }

    public function FAQ()
    {
        return view("page.faq");
    }

    public function PlayGuide()
    {
        return view("page.play-guide");
    }

    public function Cooperation()
    {
        return view("page.cowork");
    }
    
    public function memberpage()
    {
        return view("page.memberpage");
    }

    public function testMail()
    {
        $order = DB::table('orders')->where('MerchantOrderNo', '20160515092216')->first();

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
            'TradeNo'           => $order->TradeNo,
            'TradeTime'         => $order->PayTime,
            'TotalPrice'        => $order->TotalPrice,
            'MerchantOrderNo'   => $order->MerchantOrderNo,
            'ItemDesc'          => $order->ItemDesc,
            'user_name'         => $order->user_name,
            'user_phone'        => $order->user_phone,
            'user_email'        => $order->user_email,
            'activity_name'     => $act->title,
            'activity_location' => $act->location,
            'ticket_infos'      => $ticket_infos,
        );

        // DB::table('orders')->where('MerchantOrderNo', $order->MerchantOrderNo)->update($updateArray);

        $hoster = DB::table('users')->find($act->hoster_id);

        Mail::send('activity.confirm_text', array('tickets' => $tickets), function($message) use ($tickets, $hoster) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to( $tickets->user_email, $tickets->user_name )
                    // ->bcc( $hoster->email, $hoster->name )
                    ->subject('【514活動報名通知】您好'. $tickets->user_name .'，您已經成功報名『'. $tickets->ItemDesc .'』');
        });
        return 'Mail sended';
    }

    public function addSubscribe(Request $request)
    {
        if ($request->email == "") {
            return Response::json([
                  'result' => '請勿輸入空白資訊！'
              ], 201);
        } else {
            $subscribes = DB::table('subscribes');
            $sub = $subscribes->where('email', $request->email)->get();
            if ( empty($sub) ) {
                $subscribes->insert(array('email' => $request->email));
                return Response::json([
                      'result' => '感謝您！您已訂閱成功，有新的活動我們會第一時間通知您！'
                  ], 201);
            } else {
                return Response::json([
                      'result' => '感謝您！您已存在於訂閱戶當中！'
                  ], 201);
            }
        }
    }
}
