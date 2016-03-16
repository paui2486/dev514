<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;
use Log;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class maincontroller extends controller
{
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
            'name = company'            => '共盈科技股份有限公司: 514 Life',
            'name = abstract'           => '514 活動頻道，辦活動超簡單，收款超級快，精準統計報名人數，省去您的金流義務麻煩',
            'name = description'        => '514 活動頻道，辦活動超簡單，收款超級快，精準統計報名人數，省去您的金流義務麻煩',
            'name = fragment'           => '!',
            'property = og:title'       => '514 生活頻道 - 讓生活更有意思',
            'property = og:url'         => URL::current(),
            'property = og:type'        => 'website',
            'property = og:description' => '514 活動頻道，辦活動超簡單，收款超級快，精準統計報名人數，省去您的金流義務麻煩',
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
                        ->take(4)
                        ->get();
        return $newBlogs;
    }

    private function getNewActivity()
    {
        $newActivity = DB::table('activities')
                        ->where('activities.status', '>=', 2)
                        ->leftJoin('users',                 'users.id',      '=',   'activities.host_id')
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
                    ->rightJoin('users',             'users.id',      '=',   'activities.host_id')
                    ->leftJoin('act_tickets',        'activities.id', '=',   'act_tickets.activity_id')
                    ->select(
                        'activities.id as activity_id', 'activities.thumbnail',         'activities.title',
                        'activities.description',       'activities.counter as count',  'act_tickets.price',
                        'act_tickets.location',         'act_tickets.run_time as date', 'users.nick as orginizer'
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
}
