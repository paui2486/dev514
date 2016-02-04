<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeMeta   = array(
                        'name = title'              => '514 生活頻道 - 讓生活更有意思',
                        'name = author'             => '514 生活頻道',
                        'name = copyright'          => 'Copyright © 514 All rights reserved.',
                        'name = description'        => '',
                        'property = og:title'       => '514 生活頻道 - 讓生活更有意思',
                        'property = og:url'         => 'http://www.514.com.tw/',
                        'property = og:image'       => '',
                        'property = og:description' => '',
                        'property = og:app_id'      => '',
                        'property = og:admins'      => '',
                      );

        $homeBanner = array();
        $bannerTemplate = (object) array(
                            'image'     => 'img/flags.png',
                            'caption'   => 'GG拉',
                        );
        for ($x=0; $x<3; $x++) {
            array_push($homeBanner, $bannerTemplate);
        }

        $homeFilter = array(
                        'who'   => array(
                                        1 => '父母',
                                        2 => '親友',
                                        3 => '男女'
                                    ),
                        'what'  => array(
                                        1 => '遊樂園',
                                        2 => '國外',
                                        3 => '旅遊'
                                    ),
                        'where' => array(
                                        1 => '台北',
                                        2 => '屏東'
                                    ),
                        'when'  => array('日曆'),
                        'price' => array(
                                        1 => '100',
                                        2 => '1000',
                                        3 => '3000'
                                    ),
                    );

        $newBlog = array();
        $blogTemplate = (object) array(
                            'thumbnail'     => 'img/flags.png',
                            'title'         => 'L`age 熟成餐廳-最愛的秘密基地',
                            'created_at'    => '2016/01/28',
                            'category'      => '食記',
                            'author'        => 'iwine',
                            'description'   => 'Emma 對於灑在水波蛋上的食材太好奇了，所以先來試試原味猜猜看是什麼？？吃起來脆脆的...有烤過＃！％！＃＄！“＃！”＃！“＃這邊開始要縮囉',
                        );
        for ($x=0; $x<4; $x++) {
            array_push($newBlog, $blogTemplate);
        }

        $newActivity = array();
        $activityTemplate = (object) array(
                                'activity_id'   => '1',
                                'title'         => '阿里山神木群，大自然的鬼斧神工',
                                'count'         => '475',
                                'thumbnail'     => 'img/flags.png',
                                'description'   => '說到嘉義的知名景點，不得不提到名揚國際的阿里山，尤其是什麼鬼。。。。。％”＃＄“＃＄”＃＄！這邊要開始縮囉',
                                'price'         => money_format("%n", 1200),
                                'date'          => '2016//02/23',
                                'location'      => '嘉義縣竹崎鄉',
                                'orginizer'     => '愛旅遊工作坊',
                            );
        for ($x=0; $x<3; $x++) {
            array_push($newActivity, $activityTemplate);
        }

        $totalActivity  = array();
        $totalActivityTemplate = (object) array(
                                    'cat_id'        => '1',
                                    'cat_thumbnail' => 'img/flags.png',
                                    'cat_title'     => '美食美酒',
                                    'cat_logo'      => 'img/controls.png',
                                    'cat_content'   => (object) $newActivity,
                                );
        for ($x=0; $x<3; $x++) {
            array_push($totalActivity, $totalActivityTemplate);
        }

        $home       = (object) array(
                        'meta'          => (object) $homeMeta,
                        'banner'        => (object) $homeBanner,
                        'filter'        => (object) $homeFilter,
                        'newBlog'       => (object) $newBlog,
                        'newActivity'   => (object) $newActivity,
                        'totalActivity' => (object) $totalActivity,
                      );
        return view('home', compact('home'));
    }
}
