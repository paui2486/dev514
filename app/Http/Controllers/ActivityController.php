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
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;

class ActivityController extends Controller
{
    public function index($id)
    {
        // $slideCategory = Library::getSlideCategory();
        //
        $activity = DB::table('activities')
                      ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                      ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                      ->select(array(
                          'activities.id' ,       'activities.title',           'activities.tag_ids',
                          'activities.thumbnail', 'activities.description',     'activities.location',
                          'activities.content',   'activities.activity_start',  'activities.activity_end',
                          'activities.counter',   'activities.category_id',     'activities.max_price',
                          'activities.min_price', 'activities.remark',          'activities.time_range',
                          'categories.name as locat_name',  'users.name as hoster', 'users.nick as nick',
                          'users.avatar as host_photo',    'users.description as host_destricption',
                          'activities.ticket_description', 'activities.hoster_id', 'activities.fkul', 'activities.banner',
                      ))
                      ->where('activities.id', $id)
                      ->first();
        if (empty($activity)){
            return Redirect::to('');
        } else {
            $tickets = DB::table('act_tickets')
                        ->where('activity_id', $activity->id)
                        ->where('left_over', '>', '0')
                        ->select(array(
                            'id', 'name', 'left_over', 'run_time', 'price', 'ticket_start', 'ticket_end', 'location', 'description', 'sale_start', 'sale_end'
                        ))
                        ->where('sale_start', '<=', date('Y-m-d H:i:s'))
                        ->where('sale_end',   '>=', date('Y-m-d H:i:s'))
                        ->get();

            $suggests = DB::table('activities')
                          ->leftJoin('categories as cat', 'activities.category_id', '=', 'cat.id')
                          ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                          ->where('activities.status', '>=', 4)
                          ->where('activities.category_id', $activity->category_id)
                          ->where('activities.id', '!=', $activity->id)
                          ->select(array(
                            'activities.thumbnail', 'activities.title',     'activities.description',
                            'activities.location',  'activities.min_price', 'activities.activity_start',
                            'categories.name as locat_name', 'activities.id', 'cat.name as cat_name'
                          ))
                          // ->groupBy('activities.title')
                          ->orderBy('activities.created_at', 'ASC')
                          ->take(3)
                          ->get();

        //     # 這行會有錯誤，會修改 activity_start 的時間 （ 於 php 7 用 increment 的話
            DB::table('activities')->where('id', $id)->update(array('counter'=> $activity->counter + 1, 'activity_start' => $activity->activity_start));

            $meta   = array(
                'charset = UTF-8'           => 'text/html',
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
                'property = og:type'        => 'product.item',
                'property = og:description' => $activity->description,
                'property = og:site_name'   => '514 活動頻道',
                'property = og:locale'      => 'zh_TW',
                'property = og:image'       => asset($activity->thumbnail),
                // 'property = fb:page_id'     => '514 Life',
                'property = fb:app_id'      => env("FACEBOOK_CLIENT_ID"),
            );
        }
        return view("activity.index", compact('meta', 'activity', 'tickets', 'suggests'));
    }

    public function showCategory($category)
    {
        $slideCategory = Library::getSlideCategory();

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

            return view('activity.list', compact('meta', 'header_categories', 'category', 'activity_list', 'slideCategory'));
        }
    }

    public function showActivity($category, $title)
    {
        $slideCategory = Library::getSlideCategory();

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
                        'users.avatar as host_photo',   'users.description as host_destricption',
                        'activities.ticket_description'
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
                            'id', 'name', 'left_over', 'run_time', 'price', 'ticket_start', 'ticket_end', 'location', 'description'
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

            # 這行會有錯誤，會修改 activity_start 的時間 （ 於 php 7
            #DB::table('activities')->where('id', $activity->id)->increment('counter');

            $meta   = array(
                'charset = UTF-8'           => 'text/html',
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
                'property = og:type'        => 'product.item',
                'property = og:description' => $activity->description,
                'property = og:site_name'   => '514 活動頻道',
                'property = og:locale'      => 'zh_TW',
                'property = og:image'       => asset($activity->thumbnail),
                'property = fb:page_id'     => '514 Life',
                'property = fb:app_id'      => '509584332499899',
                'property = fb:admins'      => '1910444804523',
            );
            return view('activity.index', compact('meta', 'activity', 'tickets', 'suggests', 'slideCategory'));
        }
    }

    public function showResult(Request $request)
    {
        // return Input::all();
        $slideCategory = Library::getSlideCategory();
        // Log::error(Input::all());
        // Log::error(URL::previous());
        // return $request->segment(1);
        $main       = new MainController();
        $filter     = $main->getFilter();

        $meta       = array();
        $activities = array();

        $query      = DB::table('activities')
                        ->leftJoin('categories as cat', 'activities.category_id', '=', 'cat.id')
                        ->leftJoin('categories', 'categories.id', '=', 'activities.location_id')
                        ->where('activities.status', '>=', 4)
                        ->select(array(
                          'activities.id',        'activities.title' ,           'activities.description',
                          'activities.min_price', 'activities.activity_start',   'activities.activity_end',
                          'activities.location',  'categories.name as locat_name', 'activities.thumbnail',
                          'activities.max_price', 'cat.name as cat_name'
                        ))
                        ->orderBy('activities.activity_start');

        if (!isset($request->showOld)) {
            $query = $query->where('activities.activity_end', '>=', date('Y-m-d'));
        }

        if ($request->isMethod('post'))
        {
            $query = $query->leftJoin('categories_data', 'categories_data.activity_id', '=', 'activities.id')
                          ->groupBy('categories_data.activity_id')
                          ->orderBy( DB::raw('count(*)') , 'desc');

            $selects     = ($request->selects)? $request->selects : array( $request->withWho, $request->playWhat, $request->goWhere );
            foreach ($selects as $key => $value) {
                if ( $value == "" ) { unset($selects[$key]); }
            }

            if (!empty($selects)) {
                // Log::error($selects);

                $rmArray = DB::table('categories')->where('type', 6)->lists('id');
                $inMArray = array_intersect($rmArray, $selects);
                $outMArray = array_diff($selects, $rmArray);
                if ( !empty($inMArray) ) {
                    $vMoney = DB::table('categories')->whereIn('id', $inMArray)->max('value');
                    $query = $query->where('min_price', '<=', $vMoney);
                }
                if ( !empty($outMArray) ) {
                    $query   = $query->whereIn('categories_data.category_id', $outMArray );
                }
            }

            $search      = $request->keySearch;
            if ( $search != "" ) {
                $query   = $query->where('activities.title', 'like', "%$search%" )
                              ->orWhere('activities.description', 'like', "%$search%" );
            }

            $searchMoney = $request->haveMoney;
            if ( $searchMoney != "" ) {
                $value = DB::table('categories')->find($searchMoney)->value;
                $query = $query->where('max_price', '<=', $value);
            }

            $searchTime  = $request->atWhen;
            if ($searchTime != "" ) {
                $endtime = date("Y-m-d 00:00:00" , mktime(0,0,0,date("m"), date("d")+$searchTime,date("Y")) );
                $query   = $query->where('activity_end', '<=', $endtime);
            }

            $sortBy     = $request->sortBy;
            if ( $sortBy == 'hot' ) {
                $activities = $query->orderBy( 'activities.counter', 'desc' )->get();
            } elseif ( $sortBy == 'coupon' ) {
                $activities = $query->orderBy( 'activities.price',   'asc'  )->get();
            } else {
                $activities = $query->get();
            }
            $tmp_Array = array_merge( $selects, [$searchTime, $searchMoney] );
            if ( $request->url() == URL('activity/data') ) {
                // Log::error($activities);
                return $activities;
            }
        } else {
            $activities = $query->get();
        }
        // Log::error($activities);

        foreach($filter as $key => $value) {
          # code...
            foreach ($value as $target) {
              # code...
                if ( isset($selects) ) {
                    if ( in_array($target->id, $tmp_Array) ){
                        $target->checked = 'checked';
                    } else {
                        $target->checked = null;
                    }
                } else {
                    $target->checked = null;
                }
            }
        }
        return view('activity.search', compact('meta', 'filter', 'activities', 'slideCategory'));
    }
}
