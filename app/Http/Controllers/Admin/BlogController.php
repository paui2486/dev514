<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use App\Http\Requests\CreateBlogRequest;
// use App\Http\Requests\UpdateBlogRequest;

use DB;
use Log;
use Input;
use Redirect;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $authors    = DB::table('users')
                    ->where('author', 1)
                    ->select('id', 'name')
                    ->get();
        $categories = DB::table('categories')
                        ->where('public', 1)
                        ->where('type', 2)
                        ->select('id', 'name')
                        ->get();
        return view('admin.blog.create_edit', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Log::error($request);
        if ( $request->hasFile('thumbnail') ) {
            $id = DB::table('articles')->insertGetId([
              'title'         => $request->title,
              'author_id'     => $request->author_id,
              'category_id'   => $request->category_id,
              'thumbnail'     => $request->thumbnail,
              'content'       => $request->content,
              'tag_ids'       => $request->tags,
              'status'        => $request->status,
              'counter'       => $request->counter,
              'created_at'    => date("Y-m-d H:i:s"),
              'updated_at'    => date("Y-m-d H:i:s"),
            ]);
            $file             = $request->file('thumbnail');
            $destinationPath  = public_path() . '/uploads/articles/' . $id;
            $thumbnail        = "uploads/articles/$id/" . $file->getClientOriginalName();
            $file -> move($destinationPath, $file->getClientOriginalName());
            $temp             = DB::table('articles')->where('id', $id)->update(array('thumbnail' => $thumbnail));

        } else {
            $store            = DB::table('articles')->insert([
              'title'         => $request->title,
              'author_id'     => $request->author_id,
              'category_id'   => $request->category_id,
              'content'       => $request->content,
              'tag_ids'       => $request->tags,
              'status'        => $request->status,
              'counter'       => $request->counter,
              'created_at'    => date("Y-m-d H:i:s"),
              'updated_at'    => date("Y-m-d H:i:s"),
            ]);
        }
        return Redirect::to('dashboard/blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $article = DB::table('articles')->find($id);
        $authors = DB::table('users')
                    ->where('author', 1)
                    ->select('id', 'name')
                    ->get();
        $categories = DB::table('categories')
                        ->where('public', 1)
                        ->where('type', 2)
                        ->select('id', 'name')
                        ->get();
        return view('admin.blog.create_edit', compact('article', 'authors', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $articles = DB::table('articles')->where('id', $id);

        $updateArray = array(
          'title'         => $request->title,
          'author_id'     => $request->author_id,
          'category_id'   => $request->category_id,
          'thumbnail'     => $request->thumbnail,
          'description'   => $request->description,
          'content'       => $request->content,
          'tag_ids'       => $request->tags,
          'status'        => $request->status,
          'counter'       => $request->counter,
          'created_at'    => $request->created_at,
          'updated_at'    => date("Y-m-d H:i:s"),
        );

        if ( $request->hasFile('thumbnail') ) {
            $file                     = $request->file('thumbnail');
            $destinationPath          = public_path() . '/uploads/articles/' . $id;
            $updateArray['thumbnail'] = "uploads/articles/$id/" . $file->getClientOriginalName();
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        $articles->update($updateArray);
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $articles = DB::table('articles')->find($id);
        return view('admin.blog.delete', compact('articles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $articles = DB::table('articles')->where('id', $id);
        $articles->delete();
        return Redirect::to('dashboard/blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function data()
     {
         $articles = DB::table('articles')
                      ->leftJoin('users', 'articles.author_id', '=', 'users.id')
                      ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
                      ->select(array(
                        'articles.id', 'users.name', 'categories.name as category',
                        'articles.title', 'articles.counter', 'articles.status'))
                      ->orderBy('articles.created_at', 'ASC');

         return Datatables::of($articles)
             ->edit_column('status', '@if($status == 1) 編輯中 @elseif($status == 2) 已發布 @elseif($status == 3) 已隱藏 @else 已刪除 @endif')
             ->add_column('actions', '
                   <div style="white-space: nowrap;">
                   <a href="{{{ URL::to(\'dashboard/blog/\' . $id ) }}}?view=colorbox" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
                   <a href="{{{ URL::to(\'dashboard/blog/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
                   <input type="hidden" name="row" value="{{$id}}" id="row">
                   </div>')
             ->make();
     }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function showCategory()
    {
        return view('admin.blog.category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getCategory($id)
    {
          $category = DB::table('categories')->find($id);
          return view('admin.category.create_edit', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateCategory(Request $request, $id)
    {
          Log::error($id);
          $blogCategory = DB::table('categories')->where('id', $id);
          $blogCategory->update([
            'name'      => $request->name,
            'priority'  => $request->priority,
            'public'    => $request->public
          ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getCategoryData()
    {
        $blogCategory = DB::table('categories')
                           ->leftJoin('articles', 'articles.category_id', '=', 'categories.id')
                           ->select(array(
                             'categories.id', 'categories.name', 'categories.priority',
                             DB::raw('count(*) as articles_cnt'), 'categories.public',
                           ))
                           ->groupBy('categories.id')
                           ->where('categories.type', '2')
                           ->orderBy('categories.id', 'ASC');

        return Datatables::of($blogCategory)
            ->edit_column('public', '@if($public == 1) 顯示 @else 隱藏 @endif')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <a href="{{{ URL::to(\'dashboard/blog/category/\' . $id ) }}}?view=colorbox" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
                  <a href="{{{ URL::to(\'dashboard/blog/category/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
                  <input type="hidden" name="row" value="{{$id}}" id="row">
                  </div>')
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createCategory()
    {
        return view('admin.category.create_edit');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function storeCategory(Request $request)
    {
        $store = DB::table('categories')->insert([
            'name'          => $request->name,
            'priority'      => $request->priority,
            'public'        => $request->public,
            'type'          => '2',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function deleteCategory($id)
    {
        $category = DB::table('categories')->find($id);
        return view('admin.category.delete', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destoryCategory(Request $request, $id)
    {
        $category = DB::table('categories')->where('id', $id);
        $category->delete();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function showExpert()
    {
        return view('admin.blog.expert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getExpert()
    {
        $articles = DB::table('users')
                     ->leftJoin('articles', 'articles.author_id', '=', 'users.id')
                     ->select(array(
                       'users.id', 'users.name',
                       DB::raw('count(*) as articles_cnt'),
                       DB::raw('sum(articles.counter) as view_cnt'),
                     ))
                     ->groupBy('users.id')
                     ->orderBy('users.created_at', 'ASC');

        return Datatables::of($articles)
            ->make();
    }
}
