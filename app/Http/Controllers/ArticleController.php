<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function article()
    {
        return view("blog.article");
    }

    public function show($id)
    {
        $article = DB::table('articles')
                    ->where('articles.id', $id)
                    ->leftJoin('users', 'users.id', '=', 'articles.author_id')->first();
                    // return $article;
        return view("blog.blog", ['article' => $article]);
    }

}
