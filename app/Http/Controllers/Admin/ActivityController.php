<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;

use DB;
use Log;
use Input;
use Response;
use Redirect;
use Datatables;
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.activity.index');
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
                        ->where('type', 1)
                        ->select('id', 'name')
                        ->get();
        return view('admin.activity.create_edit', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    //  public function store(ActivityRequest $request)
     public function store(Request $request)
    {
        return Response::json($request);

        $storeArray = array(
            'title'         => $request->title,
            'author_id'     => $request->author_id,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'content'       => $request->content,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'counter'       => $request->counter,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        $id                 = DB::table('articles')->insertGetId($storeArray);
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        $params['filed']    = ['thumbnail'];
        $params['infix']    = 'articles/';
        $params['suffix']   = "$id/";

        $update             = Library::upload($params);
        $articles           = DB::table('articles')->where('id', $id);
        $result             = $articles->update($update['data']);
        return Redirect::to('dashboard/activity');
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
        return view('admin.activity.create_edit', compact('article', 'authors', 'categories'));
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
    public function update(ActivityRequest $request, $id)
    {
        $updateArray = array(
            'title'         => $request->title,
            'author_id'     => $request->author_id,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'content'       => $request->content,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'counter'       => $request->counter,
            'created_at'    => $request->created_at,
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        $params            = Library::upload_param_template();
        $params['request'] = $request;
        $params['data']    = $updateArray;
        $params['filed']   = ['thumbnail'];
        $params['infix']   = 'articles/';
        $params['suffix']  = "$id-";

        $update            = Library::upload($params);
        $articles          = DB::table('articles')->where('id', $id);
        $result            = $articles->update($update['data']);
        return Redirect::to('dashboard/activity');
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $articles = DB::table('articles')->find($id);
        return view('admin.activity.delete', compact('articles'));
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
        return Redirect::to('dashboard/activity');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function data()
     {
         $activities = DB::table('activities')
                      ->leftJoin('users', 'activities.host_id', '=', 'users.id')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->select(array(
                        'activities.id',    'users.name',         'categories.name as category',
                        'activities.title', 'activities.counter', 'activities.targets', 'activities.status'))
                      ->orderBy('activities.created_at', 'ASC');

         // need to change targets to processing bar

         return Datatables::of($activities)
             ->edit_column('status', '@if($status == 1) 編輯中 @elseif($status == 2) 已發布 @elseif($status == 3) 已隱藏 @else 已刪除 @endif')
             ->add_column('actions', '
                   <div style="white-space: nowrap;">
                   <a href="{{{ URL::to(\'dashboard/activity/\' . $id ) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
                   <a href="{{{ URL::to(\'dashboard/activity/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
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
        return view('admin.activity.category');
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
        $updateArray = array(
            'name'     => $request->name,
            'priority' => $request->priority,
            'public'   => $request->public,
        );

        $params            = Library::upload_param_template();
        $params['request'] = $request;
        $params['data']    = $updateArray;
        $params['filed']   = ['thumbnail', 'logo'];
        $params['infix']   = 'articles/';
        $params['suffix']  = 'category/';

        $update       = Library::upload($params);
        $activityCategory = DB::table('categories')->where('id', $id);
        $result       = $activityCategory->update($update['data']);
        return Redirect::to('dashboard/activity/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getCategoryData()
    {
        $activityCategory = DB::table('categories')
                           ->leftJoin('articles', 'articles.category_id', '=', 'categories.id')
                           ->select(array(
                             'categories.id', 'categories.name', 'categories.logo', 'categories.thumbnail', 'categories.priority',
                             DB::raw('count(articles.category_id) as articles_cnt'), 'categories.public',
                           ))
                           ->groupBy('categories.id')
                           ->where('categories.type', '2')
                           ->orderBy('categories.id', 'ASC');

        return Datatables::of($activityCategory)
            ->edit_column('logo', '<img src="{{ (trim($logo) == "")? asset("img/no-image.png") : asset($logo) }}" width="72" height="72"/>')
            ->edit_column('thumbnail', '<img src="{{ (trim($thumbnail) == "")? asset("img/no-image.png") : asset($thumbnail) }}" width="72" height="72"/>')
            ->edit_column('public', '@if($public == 1) 顯示 @else 隱藏 @endif')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <a href="{{{ URL::to(\'dashboard/activity/category/\' . $id ) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
                  <a href="{{{ URL::to(\'dashboard/activity/category/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
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
        $storeArray = array(
            'name'          => $request->name,
            'priority'      => $request->priority,
            'public'        => $request->public,
            'type'          => '2',
        );

        $id                 = DB::table('categories')->insertGetId($storeArray);
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        $params['filed']    = ['thumbnail', 'logo'];
        $params['infix']    = 'articles/';
        $params['suffix']   = "category/";

        $update             = Library::upload($params);
        $activityCategory       = DB::table('categories')->where('id', $id);
        $result             = $activityCategory->update($update['data']);
        return Redirect::to('dashboard/activity/category');
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
        return view('admin.activity.expert');
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
                     ->where('users.author', 1)
                     ->groupBy('users.id')
                     ->orderBy('users.created_at', 'ASC');

        return Datatables::of($articles)
            ->make();
    }
}
