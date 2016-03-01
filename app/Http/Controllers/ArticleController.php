<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function article($id)
    {
        $relate_articles = $this->getRelateArticle(3, $id);
        $relate_activities = $this->getRelateActivity(3, $id);

        $article = DB::table('articles')
                    ->where('articles.id', $id)
                    ->leftJoin('users', 'users.id', '=', 'articles.author_id')->first();
        return view( "blog.article", ['article' => $article, 'relate_articles' => $relate_articles, 'relate_activities' => $relate_activities]);
    }

    public function show($id)
    {
        $relate_articles = $this->getRelateArticle(3, $id);
        $relate_activities = $this->getRelateActivity(3, $id);
        $ad = "";
        $article = DB::table('articles')
                    ->where('articles.id', $id)
                    ->leftJoin('users', 'users.id', '=', 'articles.author_id')->first();
                    // return $article;
        return view( "blog.blog", [
                        'article'           => $article,
                        'relate_articles'   => $relate_articles,
                        'relate_activities' => $relate_activities,
                        'ad'                => $ad,
                      ]);
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
}
