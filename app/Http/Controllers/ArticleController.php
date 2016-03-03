<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Response;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{

    public function index()
    {
        $meta     = (object) $this->getBlogMeta();
        $blogHome = (object) array(
            'banner'        => $this->getBlogBanner(),
            'categories'    => $this->getBlogCategories(),
        );
        return view('blog.index', compact('blogHome', 'meta'));
    }

    public function showCategory($category)
    {
        $blogList = DB::table('categories')
                  ->leftJoin('articles', 'articles.category_id', '=', 'categories.id')
                  ->leftJoin('users', 'users.id', '=', 'articles.author_id')
                  ->select(array(
                    'articles.id',  'articles.title',   'articles.thumbnail',   'categories.name as category_name',
                    'categories.logo as category_logo', 'users.name as author', 'articles.description',
                    'articles.created_at',
                  ))
                  ->where('categories.name', '=' ,"$category")
                  ->where('public', 1)
                  ->get();
        if (!count($blogList)) {
            // 無此類別 轉回首頁
            return Redirect::to('blog');
        } else {
            return view('blog.list', compact('blogList'));
        }
    }

    public function showArticle($category, $title)
    {
        $article = DB::table('articles')
                  ->leftJoin('users', 'users.id', '=', 'articles.author_id')
                  ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
                  ->select(array(
                    'articles.id',    'articles.title',    'articles.thumbnail',
                    'users.name', 'articles.description',  'articles.content',
                    'categories.name as category_name',    'articles.created_at',
                    'articles.counter',
                  ))
                  ->where('categories.name', '=', "$category")
                  ->where('articles.title', '=', "$title")
                  ->first();
        if (!count($article)) {
            return Redirect::to('blog');
        } else {
            $relate_articles = $this->getRelateArticle(3, $article->id);
            $relate_activities = $this->getRelateActivity(3, $article->id);
            return view( "blog.article", [
                            'article'           => $article,
                            'relate_articles'   => $relate_articles,
                            'relate_activities' => $relate_activities,
                          ]);
        }
    }

    public function getRelateActivity($number, $from_id)
    {
        $relate = DB::table('activities')
                    ->where('id', '!=', $from_id)
                    ->where('status', 3)
                    ->orderBy('created_at', 'ASC')
                    ->take($number)->get();
        return $relate;
    }

    public function getRelateArticle($number, $from_id)
    {
        $relate = DB::table('articles')
                    ->where('id', '!=', $from_id)
                    ->where('status', 2)
                    ->orderBy('created_at', 'ASC')
                    ->take($number)->get();
        return $relate;
    }

    public function getBlogMeta()
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
        return $blogMeta;
    }

    public function getBlogBanner()
    {
        $blog_banner = DB::table('articles')
                        ->join('users', 'users.id', '=', 'articles.author_id')
                        ->select(array(
                          'articles.id',    'articles.thumbnail as image',
                          'articles.title', 'users.name as author', 'articles.created_at as time'
                        ))
                        ->where('articles.status', 2)
                        ->orderBy('time', 'ASC')
                        ->get();
        return $blog_banner;
    }

    public function getBlogCategories()
    {
        $blogCategories = DB::table('categories')
                          ->select(array(
                            'id', 'name', 'logo', 'thumbnail'
                          ))
                          ->where('public', 1)
                          ->where('type', 2)
                          ->get();

        $allTopicBlogs = array();

        foreach ($blogCategories as $category)
        {
            $blogs = DB::table('articles')
                      ->leftJoin('users', 'users.id', '=', 'articles.author_id')
                      ->select(array(
                        'articles.id',    'articles.thumbnail',
                        'articles.title', 'users.name as author', 'articles.created_at as time',
                        'articles.description as info'
                      ))
                      ->where('articles.status', 2)
                      ->where('category_id', $category->id)
                      ->orderBy('time', 'ASC')
                      ->take(4)
                      ->get();

            if(!count($blogs)) {
                continue;
            } else {
                $blogCategories = (object) array(
                      'cat_id'        => $category->id,
                      'cat_title'     => $category->name,
                      'cat_logo'      => $category->logo,
                      'cat_content'   => $blogs,
                );
                array_push($allTopicBlogs, $blogCategories);
            }
        }

        return (object) $allTopicBlogs;
    }

}
