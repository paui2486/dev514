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
