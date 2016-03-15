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
        $header_categories  = $this->getCategory();
        $blogHome = (object) array(
            'banner'        => $this->getBlogBanner(),
            'categories'    => $this->getBlogCategories(),
        );
        return view('blog.index', compact('blogHome', 'meta', 'header_categories'));
    }

    public function showCategory($category)
    {
        $meta     = (object) $this->getBlogMeta();
        $header_categories  = $this->getCategory();
        $category = DB::table('categories')
                      ->where('name', $category)
                      ->where('type', 2)
                      ->where('public', 1)
                      ->first();

        if (empty($category)) {
            // 無此類別 轉回首頁
            return Redirect::to('blog');
        } else {
            $blogList = DB::table('articles')
                          ->rightJoin('users', 'users.id', '=', 'articles.author_id')
                          ->select(array(
                            'articles.id',  'articles.title',   'articles.thumbnail',
                            'users.name as author', 'articles.description', 'articles.created_at',
                          ))
                          ->where('articles.category_id', '=' , $category->id )
                          ->paginate(5);
            return view('blog.list', compact('meta', 'header_categories', 'category', 'blogList'));
        }
    }

    public function showArticle($category, $title)
    {
        $header_categories  = $this->getCategory();
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
            DB::table('articles')->where('id', $article->id)->increment('counter');
            $relate_articles = $this->getRelateArticle(3, $article->id);
            $relate_activities = $this->getRelateActivity(3, $article->id);
            return view( "blog.article", [
                            'article'           => $article,
                            'relate_articles'   => $relate_articles,
                            'relate_activities' => $relate_activities,
                            'header_categories' => $header_categories
                          ]);
        }
    }

    public function getCategory()
    {
        $category = DB::table('categories')
                      ->where('type', 2)
                      ->get();
        return $category;
    }

    public function getRelateActivity($number, $from_id)
    {
        $relate = DB::table('activities')
                    ->leftJoin('categories', 'categories.id', '=', 'activities.category_id')
                    ->select(array(
                      'activities.title', 'activities.created_at', 'categories.name as category_name',
                      'activities.thumbnail'
                    ))
                    ->where('activities.id', '!=', $from_id)
                    ->where('activities.status', 3)
                    ->orderBy('activities.created_at', 'ASC')
                    ->take($number)->get();
        return $relate;
    }

    public function getRelateArticle($number, $from_id)
    {
        $relate = DB::table('articles')
                    ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')
                    ->select(array(
                      'articles.title', 'articles.created_at', 'categories.name as category_name',
                      'articles.thumbnail'
                    ))
                    ->where('articles.id', '!=', $from_id)
                    ->where('articles.status', 2)
                    ->orderBy('articles.created_at', 'ASC')
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
