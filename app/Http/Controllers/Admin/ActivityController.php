<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;
use App\Http\Requests\UpdateActivityRequest;

use DB;
use Log;
use Auth;
use Input;
use Session;
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
        $tickets    = array();
        $prices     = array();
        $array_key  = "price";
        $prices     = array_map(function($item) use($array_key) {
                        return ($item[$array_key] === "")? 0 : $item[$array_key];
                      }, $request->ticket);

        $activity_range = array();
        preg_match_all("/(\d+-\d+-\d+\s\d+:\d+)/", $request->activity_range, $activity_range);

        $storeArray = array(
            'title'         => $request->title,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'ticket_description'   => $request->ticket_description,
            'location'      => $request->location,
            'content'       => $request->content,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'time_range'    => $request->time_range,
            'max_price'     => max($prices),
            'min_price'     => min($prices),
            'activity_start'=> $activity_range[0][0],
            'activity_end'  => $activity_range[1][0],
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        if( Auth::user()->adminer )
        {
            $storeArray['hoster_id'] = $request->hoster_id;
            $storeArray['counter'] = $request->counter;
        } else {
            $storeArray['hoster_id'] = Auth::id();
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

        foreach ($request->ticket as $act_ticket) {
            $act_ticket  = (object) $act_ticket;

            $sale_range  = array();
            $sale_time   = ($act_ticket->sale_time === "")? date("Y-m-d H:i") . ' - ' . ("Y-m-d H:i") : $act_ticket->sale_time;
            preg_match_all("/(\d+-\d+-\d+\s\d+:\d+)/", $sale_time,  $sale_range);

            $event_range = array();
            $event_time  = ($act_ticket->event_time === "")? date("Y-m-d H:i") . ' - ' . ("Y-m-d H:i") : $act_ticket->event_time;
            preg_match_all("/(\d+-\d+-\d+\s\d+:\d+)/", $event_time, $event_range);

            $insert = array(
                        'activity_id'   => $activity_id,
                        'ticket_start'  => $event_range[0][0],
                        'ticket_end'    => $event_range[1][0],
                        'sale_start'    => $sale_range[0][0],
                        'sale_end'      => $sale_range[1][0],
                        'location'      => $request->location,
                        'name'          => $act_ticket->name,
                        'status'        => $act_ticket->ticket_status,
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
                        ->where('hoster', 1)
                        ->select('id', 'name')
                        ->get();
        } else {
            $activity = DB::table('activities')
                          ->where('id', $id)
                          ->where('hoster_id', Auth::id())
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
                        ->where('type', 1)
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
    public function update(UpdateActivityRequest $request, $id)
    {
        $activity_range = array();
        preg_match("/(.*)\s-\s(.*)/", $request->activity_range, $activity_range);

        $updateArray = array(
            'title'         => $request->title,
            'category_id'   => $request->category_id,
            'description'   => $request->description,
            'ticket_description'   => $request->ticket_description,
            'location'      => $request->location,
            'content'       => $request->content,
            'time_range'    => $request->time_range,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'activity_start'=> $activity_range[1],
            'activity_end'  => $activity_range[2],
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        if( Auth::user()->adminer )
        {
            $updateArray['hoster_id'] = $request->hoster_id;
            $updateArray['counter']   = $request->counter;
        } else {
            $updateArray['hoster_id'] = Auth::id();
        }

        $activity_id        = $id;
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $updateArray;
        $params['filed']    = ['thumbnail'];
        $params['infix']    = 'activities/';
        $params['suffix']   = "$activity_id/";

        $update             = Library::upload($params);
        $activity           = DB::table('activities')->where('id', $activity_id);
        $result             = $activity->update($update['data']);

        return Redirect::to('dashboard/activity');
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $activity = DB::table('activities')->find($id);
        return view('admin.activity.delete', compact('activity'));
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
        $activities = DB::table('activities')
                    ->leftJoin('users',      'activities.hoster_id',     '=', 'users.id')
                    ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                    ->select(array(
                      'activities.id',       'users.name',             'categories.name as category',
                      'activities.title',    'activities.counter',     'activities.targets',          'activities.status'))
                    ->orderBy('activities.created_at', 'ASC');

        if (!Auth::user()->adminer){
            $activities->where('users.id', Auth::id());
        }
       // need to change targets to processing bar

       return Datatables::of($activities)
           ->edit_column('status', '@if($status == 1) 編輯中 @elseif($status ==3 ) 審核中 @elseif($status == 4) 已發布 @elseif($status == 2) 已隱藏 @else 已刪除 @endif')
           ->add_column('actions', '
                 <div style="white-space: nowrap;">
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id ) }}}"                class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 活動</a>
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id  . \'/tickets\') }}}" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 票卷</a>
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id . \'/delete\' ) }}}"  class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
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

        $update            = Library::upload($params);
        $activityCategory  = DB::table('categories')->where('id', $id);
        $result            = $activityCategory->update($update['data']);
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
                           ->leftJoin('articles',    'articles.category_id', '=', 'categories.id')
                           ->select(array(
                             'categories.id',        'categories.name',      'categories.logo',
                             'categories.thumbnail', 'categories.priority',
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
                  <a href="{{{ URL::to(\'dashboard/activity/category/\' . $id ) }}}"               class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
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
            'type'          => '1',
        );

        $id                 = DB::table('categories')->insertGetId($storeArray);
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        $params['filed']    = ['thumbnail', 'logo'];
        $params['infix']    = 'articles/';
        $params['suffix']   = "category/";

        $update             = Library::upload($params);
        $activityCategory   = DB::table('categories')->where('id', $id);
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

    public function showTicket()
    {
        return view('admin.activity.ticket');
    }

    public function getTicket()
    {
        $ticket = DB::table('orders')
                     ->leftJoin('users', 'users.id', '=', 'orders.hoster_id')
                     ->leftJoin('act_tickets', 'act_tickets.id', '=', 'orders.ticket_id')
                     ->select(array(
                        'orders.id', 'orders.ItemDesc', 'act_tickets.ticket_start',
                        'orders.user_email', 'orders.user_phone', 'orders.status'
                     ))
                     ->where('orders.user_id', Auth::id())
                     ->orderBy('users.created_at', 'ASC');

        return Datatables::of($ticket)
            ->edit_column('status', '@if($status === 0) 未付款 @elseif ($status === 1) 已付款 @else 付款失敗 @endif')
            ->make();
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
            ->add_column('setting','相關設定？')
            ->make();
    }

    public function askExpert()
    {
        return view('admin.activity.register_expoert');
    }

    public function regExpert(Request $request)
    {
        $storeArray = array(
          'name'    => $request->name,
          'TaxID'   => $request->TaxID,
          'address' => $request->address,
          'phone'   => $request->phone,
          'user_id' => Auth::id(),
          'contact_name'  => $request->contact_name,
          'contact_phone' => $request->contact_phone,
          'contact_email' => $request->contact_email,

        );

        $id                 = DB::table('companys')->insertGetId($storeArray);


        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        // $params['filed']    = ['ID_path', 'Bank_path'];
        $params['filed']    = array();
        $params['infix']    = '../../storage/uploads/';
        $params['suffix']   = "CompanysID/";

        if (!empty($request->ID_path)) {
            array_push($params['filed'], 'ID_path');
        }
        if (!empty($request->Bank_path)) {
            array_push($params['filed'], 'Bank_path');
        }

        $update             = Library::upload($params);
        $result             = DB::table('companys')->where('id', $id)
                                ->update($update['data']);
        if ($result) {
            Session::flash('message', '申請完成，恭喜您已經能舉辦活動，靜待系統進行審核');
            DB::table('users')
                  ->where('id', Auth::id())
                  ->update(array(
                    'hoster'      => 1,
                    'updated_at'  => date("Y-m-d H:i:s"),
                  ));
        }

        return Redirect::to('dashboard');
    }

    public function showCheckAct()
    {
        return view('admin.activity.check');
    }

    public function getCheckAct()
    {
        $check = DB::table('activities')
                      ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                      ->leftJoin('categories', 'categories.id', '=', 'activities.category_id')
                      ->select(array(
                        'users.name', 'activities.title', 'activities.created_at',
                        'categories.name as cat_name', 'activities.id',
                      ))
                      ->where('activities.status', 3);

        return Datatables::of($check)
            ->edit_column('id','<div style="white-space: nowrap;">
                  <a class="btn btn-info btn-sm iframe" href="{{{ url("dashboard/priview/activity/".$id) }}}" >預覽<a>
                  <div class="btn btn-success btn-sm" onclick="passActivity({{$id}})"><span class="glyphicon glyphicon-pencil"></span> 通過</div>
                </div>')
            ->make();
    }

    public function passActivity($id)
    {
        DB::table('activities')->where('id', $id)->update(array('status' => 4));
    }

    public function showPriview()
    {
        $activity = DB::table('activities')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                      ->select(array(
                        'activities.id' ,       'activities.title',           'activities.tag_ids',
                        'activities.thumbnail', 'activities.description',     'activities.location',
                        'activities.content',   'activities.activity_start',  'activities.activity_end',
                        'activities.counter',   'activities.category_id',     'activities.max_price',
                        'activities.min_price', 'activities.remark',          'activities.time_range',
                        'categories.name as category',  'users.name as hoster', 'users.nick as nick',
                        'users.avatar as host_photo',   'users.description as host_destricption'
                      ))
                      ->first();

        $tickets = DB::table('act_tickets')
                    ->where('activity_id', $activity->id)
                    ->where('left_over', '>', '0')
                    ->select(array(
                        'name', 'left_over', 'run_time', 'price', 'ticket_start', 'ticket_end', 'location', 'description'
                    ))
                    ->get();

        $suggests = DB::table('activities')
                      ->where('activities.status', '>=', 4)
                      ->where('activities.category_id', $activity->category_id)
                      ->where('activities.id', '!=', $activity->id)
                      ->select(array(
                        'activities.thumbnail', 'activities.title',     'activities.description',
                        'activities.location',  'activities.min_price', 'activities.activity_start',
                      ))
                      ->groupBy('activities.title')
                      ->orderBy('activities.created_at', 'ASC')
                      ->take(3)
                      ->get();

        DB::table('activities')->where('id', $activity->id)->increment('counter');

        $meta   = array();

        return view('activity.index', compact('meta', 'activity', 'tickets', 'suggests'));
    }
}
