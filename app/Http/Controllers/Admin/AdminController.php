<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Session;
use Cookie;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function index()
    {
        $count['blog']      = DB::table('articles')->count();
        $count['user']      = DB::table('users')->count();
        $count['activity']  = DB::table('activities')->count();
        // $count['pv']        = DB::table('users')->count();
        $count['pv']        = 0;

        $state = (object) array(
            '用戶'     => (object) array(
                'count' => $count['user'],
                'color' => 'terques',
                'icon'  => 'fa-user',
            ),
            '文章'     => (object) array(
                'count' => $count['blog'],
                'color' => 'red',
                'icon'  => 'fa-tags',
            ),
            '活動' => (object) array(
                'count' => $count['activity'],
                'color' => 'yellow',
                'icon'  => 'fa-shopping-cart',
            ),
            'Total PVs' => (object) array(
                'count' => $count['pv'],
                'color' => 'blue',
                'icon'  => 'fa-bar-chart-o',
            )
        );

        return view('admin.dashboard.index', compact('state'));
    }

    public function showMember(Request $request)
    {
        // setcookie
        // setcookie("current_user", 'gg',0,"/");
        return view('page.error');
    }
}
