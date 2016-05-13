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
    public function index()
    {
        $meta   = (object) $this->getMeta();

        $slideCategory = Library::getSlideCategory();

        $home   = (object)array(
            'banner'        => (object) $this->getBanner(),
            'filter'        => (object) $this->getFilter(),
            'newBlog'       => (object) $this->getNewBlog(),
            'newActivity'   => (object) $this->getNewActivity(),
            'totalActivity' => (object) $this->getTotalActivity(),
            'allActivity'   => (object) $this->getAllActivity(),
        );

        return view('home', compact('home', 'meta', 'slideCategory'));
    }

    private function getMeta()
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

    public function getFilter()
    {
        $filters = array();

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
            $filters[$key] = DB::table('categories')
                                ->where('type', $value)
                                ->select(array(
                                  'id', 'name'
                                ))
                                ->get();
        }
        return $filters;
    }

    private function getNewBlog()
    {
        $newBlogs = DB::table('articles')
                        ->where('articles.status', 3)
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
                        ->where('activities.status', '>=', 4)
                        ->leftJoin('users',                 'users.id',      '=',   'activities.hoster_id')
                        ->leftJoin('act_tickets',           'activities.id', '=',   'act_tickets.activity_id')
                        ->leftJoin('categories',            'categories.id', '=',   'activities.location_id')
                        ->select(array(
                            'activities.id as activity_id', 'activities.thumbnail', 'activities.title',
                            'activities.description',       'activities.counter as count',
                            'act_tickets.price',            'activities.location',  'activities.location_id',
                            'activities.activity_start as date', 'users.nick as orginizer', 'categories.name as locat_name', 'activities.activity_end as date_end',
                        ))
                        ->orderBy('activities.created_at', 'desc')
                        ->groupBy('activities.id')
                        ->take(3)->get();
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
                        'activities.location',          'activities.activity_start as date', 'users.nick as orginizer',
                        'categories.name as locat_name', 'activities.activity_end as date_end',
                    ))
                    ->orderBy('activities.created_at', 'desc')
                    // ->take(3)
                    ->get();

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
                              'users.nick as orginizer',      'activities.activity_end as date_end', 'cat.name as cat_name',
                          ))
                          ->orderBy('activities.created_at', 'desc')
                          ->get();

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
