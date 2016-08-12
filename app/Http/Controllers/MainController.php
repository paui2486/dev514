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
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends controller
{
    public function index()//主頁面的方法 可以說這個方法所撈到的資料 都是主頁面需要的
    {
        $meta   = (object) $this->getMeta();//meta的方法

        $slideCategory = Library::getSlideCategory(); //這個Library的方法 在App 底下的Library.php 裡面的方法 getSlideCategory

        $home   = (object)array(
            'banner'        => (object) $this->getBanner(),//getBanner 主頁的輪播圖 this代表方法在下方 請參照下方getBanner方法
            'filter'        => (object) $this->getFilter(),//getFilter 主頁的下拉式橫槓 this代表方法在下方 請參照下方getFilter方法
            'newBlog'       => (object) $this->getNewBlog(),//getNewBlog 主頁的最新文章 this代表方法在下方 請參照下方getNewBlog方法
            'newActivity'   => (object) $this->getNewActivity(),//getNewActivity 主頁的最新活動 this代表方法在下方 請參照下方getNewActivity方法
            'totalActivity' => (object) $this->getTotalActivity(),//
            'allActivity'   => (object) $this->getAllActivity(),//
            'hotExpert'     => (object) $this->getHotExpert(),//
        );
        return view('home', compact('home', 'meta', 'slideCategory'));
    }

    private function getMeta()//每個頁面都要寫 把它包起來 每個頁面都引用就可以
    {
        $meta   = array(
            'charset = UTF-8'           => 'text/html',
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
            'name = abstract'           => '514生活頻道想要提供最有意思的活動資訊，集結DIY動手作、講座、課程、體驗等各式各樣的活動，無論您想找活動或是辦活動，方便的線上報名與售票，514生活頻道絕對是您最好的活動寶貝，讓大家可以簡單找到，並且輕鬆享受你喜愛的生活，體驗514「有意思」的活動。',
            'name = description'        => '514生活頻道想要提供最有意思的活動資訊，集結DIY動手作、講座、課程、體驗等各式各樣的活動，無論您想找活動或是辦活動，方便的線上報名與售票，514生活頻道絕對是您最好的活動寶貝，讓大家可以簡單找到，並且輕鬆享受你喜愛的生活，體驗514「有意思」的活動。',
            'name = keywords'           => '514,活動頻道,有意思,生活,讓生活更514,活動,找活動,辦活動,達人',
            'name = fragment'           => '!',
            'property = og:title'       => '514 活動頻道 - 讓生活更有意思',
            'property = og:url'         => URL::current(),
            'property = og:type'        => 'website',
            'property = og:description' => '514生活頻道想要提供最有意思的活動資訊，集結DIY動手作、講座、課程、體驗等各式各樣的活動，無論您想找活動或是辦活動，方便的線上報名與售票，514生活頻道絕對是您最好的活動寶貝，讓大家可以簡單找到，並且輕鬆享受你喜愛的生活，體驗514「有意思」的活動。',
            'property = og:site_name'   => '514 活動頻道',
            'property = og:image'       => asset('/img/pics/activity-photo.jpg'),
            // 'property = fb:page_id'     => '514 Life',
            'property = fb:app_id'      => env("FACEBOOK_CLIENT_ID"),
        );
        return $meta;
    }

    private function getBanner()
    {
        $home_banner = DB::table('galleries')//到DB galleries 撈資料
                        ->where('position', 1) //當position欄位 = 1 就要
                        ->select(// 需要的欄位 title source caption  source as image 來源AS圖片 因為圖片不能直接存在sql 只能存路徑
                            'title', 'source as image', 'caption'
                        )
                        ->orderBy('priority', 'desc')//按造priority 降冪
                        ->get(); //取出來
        return $home_banner; //回傳
    }

    public function getFilter()
    {
        $filters = array();//filters 以陣列形式 儲存資料
        // its match categories tables type
        $data_match = array(
            'who'   => 3,
            'what'  => 1,
            'where' => 4,
            'when'  => 5,
            'price' => 6,
        );

        foreach ($data_match as $key => $value)
        {
            $filters[$key] = DB::table('categories')//到DB categories 撈資料
                                ->where('type', $value) //這個設計的很棒每個屬性都是獨立 先利用type決定屬性name決定內容 可以得到交集
                                ->select(array(
                                  'id', 'name' //抓ID根name
                                ))
                                ->get();
        }
        return $filters;
    }

    private function getNewBlog()//
    {
        $newBlogs = DB::table('articles')//到DB articles 撈資料
                        ->where('articles.status', 2)//當articles.status = 2
                        ->leftJoin('users',             'users.id',      '=',   'articles.author_id')//LEFT JOIN 可以用來建立左外部連接，查詢的 SQL 敘述句 LEFT JOIN 左側資料表 (table_name1) 的所有記錄都會加入到查詢結果中，即使右側資料表 (table_name2) 中的連接欄位沒有符合的值也一樣。
                        ->leftJoin('categories',        'categories.id', '=',   'articles.category_id')//http://www.fooish.com/sql/left-outer-join.html
                        ->select(array(
                            'articles.thumbnail',       'articles.title',       'articles.content',
                            'articles.description',     'articles.created_at',  'users.nick as author', 'users.name',
                            'categories.name as category', 'articles.counter',
                          ))
                        ->orderBy('articles.created_at', 'desc')//降冪
                        ->take(10)//取十筆
                        ->get();//取得
        return $newBlogs;//回傳
    }

    private function getHotExpert()
    {
        $experts = DB::table('users')
                        // ->Join('users_extend', 'users.id', '=','users_extend.user_id')
                        ->where('users.hoster', '>=', 1)
                        ->select(array(
                            'users.id', 'users.name', 'users.nick', 'users.description', 'users.avatar',
                            // DB::raw('SELECT (users_extend.attribute) as extend'),
                            // DB::raw('sum(articles.counter) as view_cnt'),
                          ))
                        ->groupBy('users.id')
                        ->orderByRaw("RAND()")
                        ->take(6)
                        ->get();

        foreach ($experts as $expert) {
            $users_extend = DB::table('users_extend')
                          ->where('user_id', $expert->id)
                          ->where('status', 1);
            $content = array();
            $content['capacity']    = DB::table('users_capacity')->where('user_id', $expert->id)->lists('capacity');
            $content['experience']  = $users_extend->where('attribute', '_ExpExp')    ->value('value');
            $content['name']        = $users_extend->where('attribute', '_ExpName')   ->value('value');
            $content['avatar']      = $users_extend->where('attribute', '_ExpAvatar') ->value('value');
            $content['description'] = $users_extend->where('attribute', '_ExpDesc')   ->value('value');
            $expert->content        = $content;
        }
        return $experts;
    }

    private function getNewActivity()
    {
        $newActivity = DB::table('activities')
                        ->where('activities.status', '>=', 4)
                        ->leftJoin('users',                 'users.id',      '=',   'activities.hoster_id')
                        ->leftJoin('categories',            'categories.id', '=',   'activities.location_id')
                        ->select(array(
                            'activities.id as activity_id', 'activities.thumbnail', 'activities.title',
                            'activities.description',       'activities.counter as count', 'activities.location',
                            'activities.location_id', 'activities.activity_start as date', 'activities.min_price as price',
                            'users.name', 'users.nick as orginizer', 'categories.name as locat_name', 'activities.activity_end as date_end',
                            'activities.hoster_id', 'users.avatar'
                        ))
                        ->orderBy('activities.updated_at', 'desc')
                        ->groupBy('activities.id')
                        ->take(3)->get();

        foreach ($newActivity as $activity) {
            $tickets_price = DB::table('act_tickets')
                          ->where('activity_id', $activity->activity_id)
                          ->where('act_tickets.sale_start', '<=', date('Y-m-d H:i:s'))
                          ->where('act_tickets.sale_end',   '>=', date('Y-m-d H:i:s'))
                          ->lists('price');

            $expert = DB::table('users_extend')->where('user_id', $activity->hoster_id)->lists('value','attribute');
            if (!empty($expert)) {
                  $activity->nick    = $expert['_ExpName'];
                  $activity->avatar  = $expert['_ExpAvatar'];
            }
            // $activity->price = min($tickets_price);
        }
        return $newActivity;
    }

    private function getTotalActivity()
    {
        $totalActivity = array();

        $categories = DB::table('activities')
            ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
            ->where('activities.status', '>=', 4)
            ->select(
                'categories.id', DB::raw('count(*) as count'), 'categories.value as affinity',
                'categories.thumbnail', 'categories.name', 'categories.logo'
            )
            ->groupBy('activities.category_id')
            ->orderBy('count', 'desc')
            ->get();

        foreach ($categories as $category)
        {
            if ($category->count >= 1){

                $eachActivity = DB::table('activities')
                    ->where('activities.status', '>=', 4)
                    ->where('activities.category_id', $category->id)
                    ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                    ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                    ->select(array(
                        'activities.id as activity_id', 'activities.thumbnail',              'activities.title',
                        'activities.description',       'activities.counter as count',       'activities.min_price as price',
                        'activities.location',          'activities.activity_start as date', 'users.nick as orginizer',  'users.name',
                        'activities.hoster_id',         'categories.name as locat_name', 'activities.activity_end as date_end', 'users.avatar',
                    ))
                    ->orderBy('activities.created_at', 'desc')
                    // ->take(3)
                    ->get();

                foreach ($eachActivity as $activity) {
                    $tickets_price = DB::table('act_tickets')
                                  ->where('activity_id', $activity->activity_id)
                                  ->where('act_tickets.sale_start', '<=', date('Y-m-d H:i:s'))
                                  ->where('act_tickets.sale_end',   '>=', date('Y-m-d H:i:s'))
                                  ->lists('price');
                    $expert = DB::table('users_extend')->where('user_id', $activity->hoster_id)->lists('value','attribute');
                    if (!empty($expert)) {
                          $activity->nick    = $expert['_ExpName'];
                          $activity->avatar  = $expert['_ExpAvatar'];
                    }
                    // $activity->price = min($tickets_price);
                }

                $topicActivity = (object) array(
                    'cat_id'        => $category->id,
                    'cat_thumbnail' => $category->thumbnail,
                    'cat_title'     => $category->name,
                    'cat_logo'      => $category->logo,
                    'affinity'      => $category->affinity,
                    'cat_content'   => $eachActivity,
                );

                array_push($totalActivity, $topicActivity);
            }
        }
        return $totalActivity;
    }

    public function getAllActivity()
    {
        $allActivity = DB::table('activities')
                          ->leftJoin('categories as cat', 'activities.category_id', '=', 'cat.id')
                          ->leftJoin('categories', 'categories.id', '=', 'activities.location_id')
                          ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                          ->where('activities.status', '>=', 4)
                          ->select(array(
                              'activities.id as activity_id', 'activities.thumbnail',           'activities.title',
                              'activities.description',       'activities.counter as count',    'activities.min_price as price',
                              'activities.location',          'categories.name as locat_name',  'activities.activity_start as date',
                              'activities.hoster_id',         'users.nick as orginizer',        'users.name',  'users.avatar',
                              'activities.activity_end as date_end', 'cat.name as cat_name',    'users.nick',
                          ))
                          ->where('activities.activity_end', '>=', date('Y-m-d'))
                          ->orderBy('activities.activity_start', 'asc')
                          ->get();

        foreach ($allActivity as $activity) {
            $tickets_price = DB::table('act_tickets')
                          ->where('activity_id', $activity->activity_id)
                          ->where('act_tickets.sale_start', '<=', date('Y-m-d H:i:s'))
                          ->where('act_tickets.sale_end',   '>=', date('Y-m-d H:i:s'))
                          ->lists('price');
            $expert = DB::table('users_extend')->where('user_id', $activity->hoster_id)->lists('value','attribute');
            if (!empty($expert)) {
                  $activity->nick    = $expert['_ExpName'];
                  $activity->avatar  = $expert['_ExpAvatar'];
            }
            // $activity->price = min($tickets_price);
        }

        return $allActivity;
    }


    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code){
            return Redirect::to("register");
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user) {
            return Redirect::to("register");
        }

        $user->email_confirmed   = 1;
        $user->confirmation_code = null;
        $user->save();

        Auth::loginUsingId($user->id);

        return Redirect::to("dashboard/member#tab-0");
    }
}
