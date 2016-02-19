<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogController extends Controller
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
        $blogMeta   = array(
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

        $blogBanner = array();

        $bannerTemplate = (object) array(
            'image'     => 'img/1920/homebanner_01.jpg',
            'title'     => '今天好煩躁 什麼都失敗',
            'author'     => 'Grace',
            'time'     => '2015.01.02',
        );

        for ($x=0; $x<3; $x++) {
            array_push($blogBanner, $bannerTemplate);
        }

        $blogCategories = array();
        $eachTopicNewBlogs = (object) array(
            'id'            => 1,
            'time'          => '2015.01.03',
            'author'        => 'Grace',
            'title'         => '今天好煩躁 什麼都失敗',
            'info'          => '健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保健保',
        );

        $threeTopicNewBlogs = array();
        for ($x=0; $x<3; $x++) {
            array_push($threeTopicNewBlogs, $eachTopicNewBlogs);
        }

        $totalBlogTemplate = (object) array(
            'cat_id'        => '1',
            'cat_title'     => '人物',
            'cat_logo'      => 'img/controls.png',
            'cat_content'   => $threeTopicNewBlogs,
        );

        for ($x=0; $x<3; $x++) {
            array_push($blogCategories, $totalBlogTemplate);
        }

        $blogHome   = (object) array(
            'meta'          => (object) $blogMeta,
            'banner'        => (object) $blogBanner,
            'categories'    => (object) $blogCategories,
        );

//        return json_encode($blogHome);
        return view('blog.index', compact('blogHome'));
    }
}
