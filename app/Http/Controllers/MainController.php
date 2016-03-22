<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;
use Log;
use Auth;
use Input;
use Redirect;
use Response;
use App\User;
use App\Pay2go;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class maincontroller extends controller
{
    public function test(Request $request)
    {
        Log::error(Input::all());
        // return Input::all();

        $ticket = DB::table('act_tickets')
                    ->where('id', $request->ticket_id)
                    ->where('left_over', '>=', $request->purchase_number)
                    ->first();

        if (empty($ticket)) {
          //  return some view about error message
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
                                'ReturnURL'         =>  url('purchase/result'),
                                // "NotifyURL"         =>  url('pay2go/callback'),
                            );

            //  檢查碼
            $result["CheckValue"]	=   $Pay2go->get_check_value($result, $merKey, $merIV);

            //  送出按鈕
            $submitButtonStyle      =   "<input id='Pay2goMgr' name='submit' type='submit' value='送出' />";
            Log::info($result);
            return $Pay2go->create_form($result, NULL, TRUE, $autoSubmit, 0, $submitButtonStyle);

            return Input::all();
        }
    }

    public function test2()
    {
        $result_sample = array (
          'Status' => 'SUCCESS',
          'Message' => '授權成功',
          'Result' => '{"MerchantID":"11606075","Amt":100,"TradeNo":"16032012483184990","MerchantOrderNo":"20160320044815","RespondType":"JSON","CheckCode":"797C09DDCEB509036BC938CEC607F8F41267AD26A7BDFAB208AB597D95A66A1B","IP":"220.137.4.149","EscrowBank":"KGI","ItemDesc":"\\u842c\\u8056\\u4e4b\\u591c -  x 1","IsLogin":false,"PaymentType":"CREDIT","PayTime":"2016-03-20 12:48:31","RespondCode":"00","Auth":"930637","Card6No":"400022","Card4No":"2222","Exp":"1903","TokenUseStatus":0,"InstFirst":100,"InstEach":0,"Inst":0,"ECI":""}',
        );

        $result = json_decode($result_sample['Result']);
        // return Response::json(Input::all());
        return Response::json($result);
    }

    public function index()
    {
        $meta   = (object) $this->getMeta();

        $home   = (object)array(
            'banner'        => (object) $this->getBanner(),
            'filter'        => (object) $this->getFilter(),
            'newBlog'       => (object) $this->getNewBlog(),
            'newActivity'   => (object) $this->getNewActivity(),
            'totalActivity' => (object) $this->getTotalActivity(),
        );
        // return Response::json($home);
        return view('home', compact('home', 'meta'));
    }

    private function getMeta()
    {
        $meta   = array(
            'charset = UTF-8'           => 'text/html',
            'http-equiv = refresh'      => '200;url='.URL::current(),
            'name = google-site-verification' => '1qpynM1neEq_KsaE13qkYgSNKXaGU7X8nkIeXrgJCwY',
            'name = google'             => 'notranslate',
            'name = URL'                => URL::current(),
            'name = title'              => '514 活動頻道 - 讓生活更有意思',
            'name = author'             => '514 活動頻道',
            'name = publisher'          => '514 活動頻道',
            'name = rating'             => 'general',
            'name = robots'             => 'index,follow',
            'name = spiders'            => 'all',
            'name = webcrawlers'        => 'all',
            'name = copyright'          => 'Copyright ©2016 514 Life Inc. All rights reserved.',
            'name = company'            => '共贏科技股份有限公司: 514 Life',
            'name = abstract'           => '514 活動頻道，有意思的活動 讓生活更514 找活動 辦活動 都在514',
            'name = description'        => '514 活動頻道，有意思的活動 讓生活更514 找活動 辦活動 都在514',
            'name = keywords'           => '514,活動頻道,有意思,生活,讓生活更514,活動,找活動,辦活動,達人',
            'name = fragment'           => '!',
            'property = og:title'       => '514 活動頻道 - 讓生活更有意思',
            'property = og:url'         => URL::current(),
            'property = og:type'        => 'website',
            'property = og:description' => '514 活動頻道，有意思的活動 讓生活更514 找活動 辦活動 都在514',
            'property = og:site_name'   => '514 活動頻道',
            'property = og:image'       => asset('/uploads/galleries/1/source-1457072725.png'),
            'property = fb:page_id'     => '514 Life',
            'property = fb:app_id'      => '509584332499899',
            'property = fb:admins'      => '1910444804523',
        );
        return $meta;
    }

    private function getBanner()
    {
        $home_banner = DB::table('galleries')
                        ->where('position', 1)
                        ->select(
                            'title', 'source as image', 'caption'
                        )
                        ->orderBy('priority', 'desc')
                        ->get();
        return $home_banner;
    }

    private function getFilter()
    {
        $filters = array();

        // its match filter_options tables position
        $data_match = array(
            'who'   => 1,
            'what'  => 2,
            'where' => 3,
            'price' => 4,
        );

        foreach ($data_match as $key => $value)
        {
            $filters[$key] = DB::table('filter_options')
                                ->where('position', $value)
                                ->lists('name');
        }
        return $filters;
    }

    private function getNewBlog()
    {
        $newBlogs = DB::table('articles')
                        ->where('articles.status', 2)
                        ->leftJoin('users',             'users.id',      '=',   'articles.author_id')
                        ->leftJoin('categories',        'categories.id', '=',   'articles.category_id')
                        ->select(
                            'articles.thumbnail',       'articles.title',       'articles.content',
                            'articles.description',     'articles.created_at',  'users.name as author',
                            'categories.name as category')
                        ->orderBy('articles.created_at', 'desc')
                        ->take(3)
                        ->get();
        return $newBlogs;
    }

    private function getNewActivity()
    {
        $newActivity = DB::table('activities')
                        ->where('activities.status', '>=', 2)
                        ->leftJoin('users',                 'users.id',      '=',   'activities.hoster_id')
                        ->leftJoin('act_tickets',           'activities.id', '=',   'act_tickets.activity_id')
                        ->leftJoin('categories',            'categories.id', '=',   'activities.category_id')
                        ->select(
                            'activities.id as activity_id', 'activities.thumbnail', 'activities.title',
                            'activities.description',       'activities.counter as count',
                            'act_tickets.price',            'activities.location',
                            'activities.activity_start as date', 'users.nick as orginizer',
                            'categories.name as category'
                        )
                        ->orderBy('activities.created_at', 'desc')
                        ->groupBy('activities.id')
                        ->take(3)
                        ->get();
        return $newActivity;
    }

    private function getTotalActivity()
    {
        $totalActivity = array();

        $categories = DB::table('activities')
            ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
            ->where('activities.status', '>=', 2)
            ->select(
                'categories.id', DB::raw('count(*) as count'),
                'categories.thumbnail', 'categories.name', 'categories.logo'
            )
            ->groupBy('activities.category_id')
            ->get();
        foreach ($categories as $category)
        {
            if ($category->count >= 1){

                $eachActivity = DB::table('activities')
                    ->where('activities.status', '>=', 2)
                    ->where('activities.category_id', $category->id)
                    ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                    ->select(
                        'activities.id as activity_id', 'activities.thumbnail',              'activities.title',
                        'activities.description',       'activities.counter as count',       'activities.min_price as price',
                        'activities.location',          'activities.activity_start as date', 'users.nick as orginizer'
                    )
                    ->orderBy('activities.created_at', 'desc')
                    ->take(3)
                    ->get();

                $topicActivity = (object) array(
                    'cat_id'        => $category->id,
                    'cat_thumbnail' => $category->thumbnail,
                    'cat_title'     => $category->name,
                    'cat_logo'      => $category->logo,
                    'cat_content'   => $eachActivity,
                );

                array_push($totalActivity, $topicActivity);
            }
        }
        return $totalActivity;
    }


    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::to("register");
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return Redirect::to("register");
        }

        $user->email_confirmed   = 1;
        $user->confirmation_code = null;
        $user->save();

        Auth::loginUsingId($user->id);

        return Redirect::to("dashboard/profile");
    }
}
