<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;

use DB;
use Log;
use Auth;
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
        if (Auth::user()->adminer) {
            $hosters  = DB::table('users')
                            ->where('hoster', 1)
                            ->select('id', 'name')
                            ->get();
        } else {
            $hosters  = array();
        }

        $categories   = DB::table('categories')
                        ->where('public', 1)
                        ->where('type', 1)
                        ->select('id', 'name')
                        ->get();
        return view('admin.activity.create_edit', compact('hosters', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    //  public function store(ActivityRequest $request)
     public function store(ActivityRequest $request)
    {
        $activity_range = array();
        preg_match("/(.*)\s-\s(.*)/", $request->activity_range, $activity_range);

        $storeArray = array(
            'title'         => $request->title,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'location'      => $request->location,
            'content'       => $request->content,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'activity_start'=> $activity_range[1],
            'activity_end'  => $activity_range[2],
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        if( Auth::user()->adminer )
        {
            $storeArray['host_id'] = $request->host_id;
            $storeArray['counter'] = $request->counter;
        } else {
            $storeArray['host_id'] = Auth::id();
        }

        $activity_id        = DB::table('activities')->insertGetId($storeArray);
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        $params['filed']    = ['thumbnail'];
        $params['infix']    = 'activities/';
        $params['suffix']   = "$activity_id/";

        $update             = Library::upload($params);
        $activity           = DB::table('activities')->where('id', $activity_id);
        $result             = $activity->update($update['data']);

        $tickets            = array();
        foreach ($request->ticket as $act_ticket) {
            $sale_range   = array();
            $event_range  = array();
            $act_ticket     = (object) $act_ticket;
            preg_match("/(.*)\s-\s(.*)/", $act_ticket->sale_time,  $sale_range);
            preg_match("/(.*)\s-\s(.*)/", $act_ticket->event_time, $event_range);
            $insert = array(
                        'activity_id'   => $activity_id,
                        'ticket_start'  => $event_range[1],
                        'ticket_end'    => $event_range[2],
                        'sale_start'    => $sale_range[1],
                        'sale_end'      => $sale_range[2],
                        'location'      => $request->location,
                        'name'          => $act_ticket->name,
                        'status'        => $act_ticket->status,
                        'price'         => $act_ticket->price,
                        'total_numbers' => $act_ticket->numbers,
                        'left_over'     => $act_ticket->numbers,
                        'description'   => $act_ticket->description,
                      );
            array_push($tickets, $insert);
        }
        $results            = DB::table('act_tickets')->insert($tickets);

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
        if (Auth::user()->adminer) {
            $activity = DB::table('activities')->find($id);
            $hosters  = DB::table('users')
                        ->where('author', 1)
                        ->select('id', 'name')
                        ->get();
        } else {
            $activity = DB::table('activities')
                          ->where('id', $id)
                          ->where('host_id', Auth::id())
                          ->first();

            if ( empty($activity) ) {
                Log::error( 'UserID :' . Auth::id() . " 想做壞事, 偷看不屬於他的活動！！" );
                return Redirect::to('dashboard/activity');
            } else {
                $hosters  = array();
            }
        }
        $categories = DB::table('categories')
                        ->where('public', 1)
                        ->where('type', 2)
                        ->select('id', 'name')
                        ->get();

        // tickets 尚未實作
        return view('admin.activity.create_edit', compact('activity', 'hosters', 'tickets', 'categories'));
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
        $activity_range = array();
        preg_match("/(.*)\s-\s(.*)/", $request->activity_range, $activity_range);

        $updateArray = array(
            'title'         => $request->title,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'location'      => $request->location,
            'content'       => $request->content,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'activity_start'=> $activity_range[1],
            'activity_end'  => $activity_range[2],
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        if( Auth::user()->adminer )
        {
            $storeArray['host_id'] = $request->host_id;
            $storeArray['counter'] = $request->counter;
        } else {
            $storeArray['host_id'] = Auth::id();
        }

        $activity_id        = $id;
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        $params['filed']    = ['thumbnail'];
        $params['infix']    = 'activities/';
        $params['suffix']   = "$activity_id/";

        $update             = Library::upload($params);
        $activity           = DB::table('activities')->where('id', $activity_id);
        $result             = $activity->update($update['data']);

        // $tickets            = array();
        // foreach ($request->ticket as $act_ticket) {
        //     $ticket_range   = array();
        //     $act_ticket     = (object) $act_ticket;
        //     preg_match("/(.*)\s-\s(.*)/", $act_ticket->time, $ticket_range);
        //     $insert = array(
        //                 'activity_id'   => $activity_id,
        //                 'ticket_start'  => $ticket_range[1],
        //                 'ticket_end'    => $ticket_range[2],
        //                 'location'      => $request->location,
        //                 'name'          => $act_ticket->name,
        //                 'status'        => $act_ticket->status,
        //                 'price'         => $act_ticket->price,
        //                 'total_numbers' => $act_ticket->numbers,
        //                 'left_over'     => $act_ticket->numbers,
        //                 'description'   => $act_ticket->description,
        //               );
        //     array_push($tickets, $insert);
        // }
        // $results            = DB::table('act_tickets')->insert($tickets);

        return Redirect::to('dashboard/activity');

    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $activities = DB::table('activities')->find($id);
        return view('admin.activity.delete', compact('activities'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $activities = DB::table('activities')->where('id', $id);
        $activities->delete();
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
        if (Auth::user()->adminer){
            $activities = DB::table('activities')
                        ->leftJoin('users', 'activities.host_id', '=', 'users.id')
                        ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                        ->select(array(
                          'activities.id',    'users.name',         'categories.name as category',
                          'activities.title', 'activities.counter', 'activities.targets', 'activities.status'))
                        ->orderBy('activities.created_at', 'ASC');
        } else {
            $activities = DB::table('activities')
                        ->leftJoin('users', 'activities.host_id', '=', 'users.id')
                        ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                        ->select(array(
                          'activities.id',    'users.name',         'categories.name as category',
                          'activities.title', 'activities.counter', 'activities.targets', 'activities.status'))
                        ->orderBy('activities.created_at', 'ASC')
                        ->where('users.id', Auth::id());
        }
       // need to change targets to processing bar

       return Datatables::of($activities)
           ->edit_column('status', '@if($status == 1) 編輯中 @elseif($status == 2) 已發布 @elseif($status == 3) 已隱藏 @else 已刪除 @endif')
           ->add_column('actions', '
                 <div style="white-space: nowrap;">
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id ) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 活動</a>
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id  . \'/tickets\') }}}" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 票卷</a>
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
                           ->where('categories.type', '1')
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
