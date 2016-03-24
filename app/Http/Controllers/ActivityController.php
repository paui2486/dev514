<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;
use Log;
use Auth;
use Input;
use Response;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    //
    public function index()
    {
        return view("activity.index");
    }

    public function Activity()
    {
        return view("activity");
    }

    public function purchase()
    {
        return view("purchase");
    }

    public function getCategory()
    {

    }

    public function showCategory($category)
    {
        // unfinish
        $header_categories  = $this->getCategory();
        $category = DB::table('categories')
                      ->where('name', $category)
                      ->where('type', 1)
                      ->where('public', 1)
                      ->first();

        if (empty($category)) {
            // 無此類別 轉回首頁
            return Redirect::to('blog');
        } else {
            $activity_list = DB::table('activities')
                          ->rightJoin('users', 'users.id', '=', 'activities.hoster_id')
                          ->select(array(
                            'activities.id',  'activities.title',   'activities.thumbnail',
                            'users.name as author', 'activities.description', 'activities.created_at',
                          ))
                          ->where('activities.category_id', '=' , $category->id )
                          ->paginate(5);

            $meta   = array(
                'charset = UTF-8'           => 'text/html',
                // 'http-equiv = refresh'      => '200;url='.URL::current(),
                'name = google-site-verification' => '1qpynM1neEq_KsaE13qkYgSNKXaGU7X8nkIeXrgJCwY',
                'name = google'             => 'notranslate',
                'name = URL'                => URL::current(),
                'name = title'              => "活動列表 - ".$category->name." - 514 活動頻道",
                'name = author'             => '514 活動頻道',
                'name = publisher'          => '514 活動頻道',
                'name = rating'             => 'general',
                'name = robots'             => 'index,follow',
                'name = spiders'            => 'all',
                'name = webcrawlers'        => 'all',
                'name = copyright'          => 'Copyright ©2016 514 Life Inc. All rights reserved.',
                'name = company'            => '共贏科技股份有限公司: 514 Life',
                'name = abstract'           => "514 活動頻道 - 活動列表 - ".$category->name,
                'name = description'        => "514 活動頻道 - 活動列表 - ".$category->name,
                'name = fragment'           => '!',
                'name = keywords'           => '514,活動頻道,有意思,生活,讓生活更514,活動,找活動,辦活動,達人',
                'property = og:title'       => "514 活動頻道 - 活動列表 - ".$category->name,
                'property = og:url'         => URL::current(),
                'property = og:type'        => 'website',
                'property = og:description' => "514 活動頻道 - 活動列表 - ".$category->name,
                'property = og:site_name'   => '514 活動頻道',
                'property = og:image'       => asset('/uploads/galleries/1/source-1457072725.png'),
                'property = fb:page_id'     => '514 Life',
                'property = fb:app_id'      => '509584332499899',
                'property = fb:admins'      => '1910444804523',
            );

            return view('activity.list', compact('meta', 'header_categories', 'category', 'activity_list'));
        }
    }

    public function showActivity($category, $title)
    {
        $activity = DB::table('activities')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                      ->where('categories.name', $category)
                      ->where('activities.title', $title)
                      ->select(array(
                        'activities.id' ,       'activities.title',           'activities.tag_ids',
                        'activities.thumbnail', 'activities.description',     'activities.location',
                        'activities.content',   'activities.activity_start',  'activities.activity_end',
                        'activities.counter',   'activities.category_id',     'activities.max_price',
                        'activities.min_price', 'activities.remark',          'activities.time_range',
                        'categories.name as category',  'users.name as hoster', 'users.nick as nick',
                        'users.avatar as host_photo',   'users.description as host_destricption'
                      ))
                      ->where('activities.status', '>=', 4)
                      ->first();

        if (empty($activity)){
            return Redirect::to('');
        } else {
            $tickets = DB::table('act_tickets')
                        ->where('activity_id', $activity->id)
                        ->where('left_over', '>', '0')
                        ->select(array(
                            'name', 'left_over', 'run_time', 'price', 'ticket_start', 'ticket_end', 'location', 'description'
                        ))
                        ->get();

            $suggests = DB::table('activities')
                          ->where('activities.status', '>=', 4)
                          ->where('activities.category_id', $activity->category_id)
                          ->where('activities.id', '!=', $activity->id)
                          ->select(array(
                            'activities.thumbnail', 'activities.title',     'activities.description',
                            'activities.location',  'activities.min_price', 'activities.activity_start',
                          ))
                          ->groupBy('activities.title')
                          ->orderBy('activities.created_at', 'ASC')
                          ->take(3)
                          ->get();

            DB::table('activities')->where('id', $activity->id)->increment('counter');

            $meta   = array(
                'charset = UTF-8'           => 'text/html',
                'http-equiv = refresh'      => '200;url='.URL::current(),
                'name = google-site-verification' => '1qpynM1neEq_KsaE13qkYgSNKXaGU7X8nkIeXrgJCwY',
                'name = google'             => 'notranslate',
                'name = URL'                => URL::current(),
                'name = title'              => '514 活動頻道 - ' . $activity->title,
                'name = author'             => ($activity->nick)?$activity->nick:$activity->hoster ,
                'name = publisher'          => '514 活動頻道',
                'name = rating'             => 'general',
                'name = robots'             => 'index,follow',
                'name = spiders'            => 'all',
                'name = webcrawlers'        => 'all',
                'name = copyright'          => 'Copyright ©2016 514 Life Inc. All rights reserved.',
                'name = company'            => '共贏科技股份有限公司: 514 Life',
                'name = abstract'           => $activity->description,
                'name = description'        => $activity->description,
                'name = fragment'           => '!',
                'name = keywords'           => '514,活動頻道,有意思,生活,讓生活更514,活動,找活動,辦活動,達人',
                'property = og:title'       => '514 活動頻道 - ' . $activity->title,
                'property = og:url'         => URL::current(),
                'property = og:type'        => 'website',
                'property = og:description' => $activity->description,
                'property = og:site_name'   => '514 活動頻道',
                'property = og:image'       => asset($activity->thumbnail),
                'property = fb:page_id'     => '514 Life',
                'property = fb:app_id'      => '509584332499899',
                'property = fb:admins'      => '1910444804523',
            );

            return view('activity.index', compact('meta', 'activity', 'tickets', 'suggests'));
        }
    }

    public function showResult()
    {
      return Input::all();
    }

}
