<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class maincontroller extends controller
{
    public function index()
    {
        $home   = (object) array(
            'meta'          => (object) $this->getMeta(),
            'banner'        => (object) $this->getBanner(),
            'filter'        => (object) $this->getFilter(),
            'newBlog'       => (object) $this->getNewblog(),
            'newActivity'   => (object) $this->getNewactivity(),
            'totalActivity' => (object) $this->getTotalactivity(),
        );
        return view('home', compact('home'));
    }

    private function getmeta()
    {
        $meta   = array(
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
        return $meta;
    }

    private function getBanner()
    {
        $banner = 
    }

    private function getFilter()
    {

    }

    private function getNewactivity()
    {

    }

    private function getTotalactivity()
    {

    }
}
