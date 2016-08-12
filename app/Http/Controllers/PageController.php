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

    public function showMember($id)
    {
        $member    = DB::table('users')->where('id', $id)->first();
        $member->tag_ids = DB::table('users_capacity')->where('user_id', $id)->lists('capacity');
        $activitys = DB::table('activities')->where('hoster_id', $id)
                      ->where('status', 4)->get();

        $extend    = DB::table('users_extend')->where('user_id', $id)->where('status', 1)->lists('value', 'attribute');

        $contact   = array();

        // dd($extend);
        // $contact = array(
        //     'Line' => (isset($extend['']))
        //     'Address'
        //     'Email'
        //     'Phone'
        //     'Mobile'
        // );

        // (isset($extend['_ExpLine']))? $contact['line'] = $member['']: '' ;
        // return $contact;

        // $member->nick = $member['_ExpName'];
        // $member->avatar = $member['_'];
        // $member->tag_ids =
        // $member->description = $member['_'];

        return view("page.member", compact('member', 'activitys'));
    }

    public function memberpage()//這個方法 將頁面導引到 view>page>memberpage.blade
    {
        return view("page.memberpage");
    }

    public function testMail()//測試郵件功能
    {
        $order = DB::table('orders')->where('MerchantOrderNo', '20160515092216')->first();//到orders表 當MerchantOrderNo = 20160515092216 first()取第一筆

        $ticket_infos = array();//$ticket_infos 為一個陣列變數
        $ticket_ids     = DB::table('orders_detail')// $ticket_ids 這個指令 到DB orders_detail
            ->where('order_id', $order->id)//當 order_id等於傳入的 order_id
            ->orderBy('id', 'ASC')->lists('sub_topic_id');//以ID做升冪排列 轉存入list>sub_topic_id  list也是array 儲存形式	ASC升冪 DES降冪
        $ticket_numbers = DB::table('orders_detail')//
            ->where('order_id', $order->id)//
            ->orderBy('id', 'ASC')->lists('sub_topic_number');//

        $ticket_infos = array();
        foreach ($ticket_ids as $key => $id) {//$ticket_ids 給一個別名 $key 參考資料http://www.1keydata.com/tw/sql/sql-as.html
            $ticket_target = DB::table('act_tickets')
                              ->where('id', $id)
                              ->select(array(//以陣列形式 一般是一筆一筆 他是包成一個陣列 參考資料 http://www.w3schools.com/php/func_mysqli_fetch_array.asp
                                'id', 'name', 'price', 'ticket_start', 'ticket_end', 'activity_id'
                              ))->first();//取第一筆
            $weekday   = ['日', '一', '二', '三', '四', '五', '六'];// 參考資料 http://php.net/manual/en/function.date.php http://www.wibibi.com/info.php?tid=PHP_strtotime_%E5%87%BD%E6%95%B8
            $weekday_start  = $weekday[date('w', strtotime($ticket_target->ticket_start))];//開始 從ticket_target這個 array date 抽取出 ticket_start 利用strtotime函式 算出UNIX 戳記時間 在用date(w) 轉換出該時間代表星期幾
            $weekday_end    = $weekday[date('w', strtotime($ticket_target->ticket_end))];//結束 同上意涵
            $ticket_target->ticket_start = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_start ) $2", $ticket_target->ticket_start);//preg_replace 可以過濾特殊字元 只剩下 $weekday_start
            $ticket_target->ticket_end   = preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday_end ) $2", $ticket_target->ticket_end); //參考資料 http://help.i2yes.com/?q=node/46
            $ticket_target->quantity     = $ticket_numbers["$key"];//票的數量 等於 $ticket_numbers["$key"]
            array_push($ticket_infos, $ticket_target);//把array$ticket_infos 加入$ticket_target 成為新的array$ticket_infos 參考資料:http://www.w3school.com.cn/php/func_array_push.asp
        }

        $act = DB::table('activities')->find( DB::table('orders_detail')->where('order_id', $order->id)->first()->topic_id );// ??? 當 order_id等於傳入的 order_id 取第一筆 轉存 topic_id
        $tickets = (object) array(
            'TradeNo'           => $order->TradeNo,//這裡都是 orders 資料表的欄位 有點奇怪
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

    public function addSubscribe(Request $request) //request為EMAIL變數
    {
        if ($request->email == "") {//如果變數內容為空白
            return Response::json([// 回傳至Response 以json格式
                  'result' => '請勿輸入空白資訊！'
              ], 201);
        } else {//如果變數內容不為空白
            $subscribes = DB::table('subscribes');//變數subscribes 為選擇DB的指令
            $sub = $subscribes->where('email', $request->email)->get();//sub變數 利用subscribes選DB 當EMAIL = $request->email get出結果
            if ( empty($sub) ) {//empty 用於判斷 內容是否為空 在此則是確認 $sub有無內容
                $subscribes->insert(array('email' => $request->email));
                return Response::json([// 回應以json格式  參考資料:https://laravel.com/docs/5.2/responses#json-responses
                      'result' => '感謝您！您已訂閱成功，有新的活動我們會第一時間通知您！'
                  ], 201);
            } else {
                return Response::json([
                      'result' => '感謝您！您已存在於訂閱戶當中！'
                  ], 201);
            }
        }
    }

    public function Expert()// 這個方法 將頁面導引到 view>page>expert.blade
    {
        return view("page.expert");
    }
}
