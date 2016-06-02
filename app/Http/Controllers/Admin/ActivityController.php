<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use App\Http\Requests\ActivityRequest;
// use App\Http\Requests\UpdateActivityRequest;

use DB;
use Log;
use Auth;
use Mail;
use View;
use Input;
use Zipper;
use Session;
use Response;
use Redirect;
use Datatables;
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    protected $AdminTabs;
    public function __construct()
    {
        if( Auth::check() ) {
            $this->AdminTabs = Library::getPositionTab(3, Auth::user()->hoster);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $AdminTabs = $this->AdminTabs;
        return view('admin.activity.index',compact('AdminTabs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $AdminTabs  = $this->AdminTabs;
        if (Auth::user()->adminer) {
            $hosters  = DB::table('users')
                          ->where('hoster', 1)
                          ->select('id', 'name')
                          ->get();
        }
        $lib        = new Library();
        $categories = (object) $lib->getFilterCategory();
        return view('admin.activity.create_edit', compact('hosters', 'categories', 'AdminTabs'));
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store(Request $request)
    {
        $tickets    = array();
        $prices     = array();
        $array_key  = "price";
        $prices     = array_map(function($item) use($array_key) {
                        return ($item[$array_key] === "")? 0 : $item[$array_key];
                      }, $request->ticket);

        $storeArray = array(
            'title'               => $request->title,
            'category_id'         => $request->soWhat,
            'description'         => $request->description,
            'ticket_description'  => $request->ticket_description,
            'location'            => $request->location,
            'location_id'         => $request->goWhere,
            'content'             => $request->content,
            'tag_ids'             => $request->tag_ids,
            'status'              => $request->status,
            'time_range'          => $request->time_range,
            'max_price'           => max($prices),
            'min_price'           => min($prices),
            'activity_start'      => $request->activity_start_date. " " . $request->activity_start_time,
            'activity_end'        => $request->activity_end_date.   " " . $request->activity_end_time,
            'created_at'          => date("Y-m-d H:i:s"),
            'updated_at'          => date("Y-m-d H:i:s"),
        );

        // 幹！什麼爛東西
        if( Auth::id() === 101 )
        {
            $storeArray['fkul'] = $request->fkul;
        }

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
        $params['dataX']      = $request->dataX;
        $params['dataY']      = $request->dataY;
        $params['dataHeight'] = $request->dataHeight;
        $params['dataWidth']  = $request->dataWidth;
        $params['dataRotate'] = $request->dataRotate;
        $params['dataScaleX'] = $request->dataScaleX;
        $params['dataScaleY'] = $request->dataScaleY;
        $update             = Library::upload($params);
        $activity           = DB::table('activities')->where('id', $activity_id);
        $result             = $activity->update($update['data']);

        if (empty($request->withWho)) {
            $categories = array();
        } else {
            $categories =  $request->withWho;
        }
        array_push( $categories, $request->soWhat  );
        array_push( $categories, $request->goWhere );

        $updateCatArray = array();
        foreach ($categories as $category) {
            array_push($updateCatArray, array('activity_id' => $activity_id, 'category_id' => $category));
        }

        DB::table('categories_data')->insert($updateCatArray);

        foreach ($request->ticket as $act_ticket) {
            $act_ticket  = (object) $act_ticket;
            $insert = array(
                        'activity_id'   => $activity_id,
                        'ticket_start'  => $act_ticket->ticket_start_date . " " . $act_ticket->ticket_start_time,
                        'ticket_end'    => $act_ticket->ticket_end_date .   " " . $act_ticket->ticket_end_time,
                        'sale_start'    => $act_ticket->sale_start_date .   " " . $act_ticket->sale_start_time,
                        'sale_end'      => $act_ticket->sale_end_date .     " " . $act_ticket->sale_end_time,
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

        if ($request->status == 3) {
            $mails = DB::table('users')->where('adminer', '>=', 1)->lists('email');
            $msg_system = '<p>Hi 514的同仁</p>
                           <p>活動主 '. Auth::user()->name .' 於514有新增送審的活動，請盡速前往審核</p>
                           <p><a href="' . url('dashboard/activity#tab-4') . '" >後台活動審核連結</a></p>';
            Mail::send('auth.emails.checkout', array('msg' => $msg_system),  function($message) use ($mails, $msg_system, $activity_id) {
                $message->from('service@514.com.tw', '514 活動頻道');
                $message->to( $mails )->subject('【514活動上架審核通知】514活動主'. Auth::user()->name .'新增活動，活動ID：'. $activity_id);
            });
        }

        return Redirect::to('dashboard/activity');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $AdminTabs    = $this->AdminTabs;
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

        $categories_data = DB::table('categories_data')
                            ->where('activity_id', $id)
                            ->pluck('category_id');
        return view('admin.activity.create_edit', compact('activity', 'hosters', 'tickets', 'categories', 'AdminTabs', 'categories_data'));
    }

    /**
     * Update the specified resource in storage.
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $updateArray = array(
            'title'         => $request->title,
            'category_id'   => $request->soWhat,
            'description'   => $request->description,
            'ticket_description'   => $request->ticket_description,
            'location_id'   => $request->goWhere,
            'location'      => $request->location,
            'content'       => $request->content,
            'time_range'    => $request->time_range,
            'tag_ids'       => $request->tag_ids,
            'status'        => $request->status,
            'activity_start'=> $request->activity_start_date. " " . $request->activity_start_time,
            'activity_end'  => $request->activity_end_date.   " " . $request->activity_end_time,
            'updated_at'    => date("Y-m-d H:i:s"),
        );

        // 幹！什麼爛東西
        if( Auth::id() === 101 )
        {
            $updateArray['fkul'] = $request->fkul;
        }

        if( Auth::user()->adminer )
        {
            $updateArray['hoster_id'] = $request->hoster_id;
            $updateArray['counter']   = $request->counter;
        } else {
            $updateArray['hoster_id'] = Auth::id();
        }

        DB::table('categories_data')->where('activity_id', $id)->delete();

        if (empty($request->withWho)) {
            $categories = array();
        } else {
            $categories =  $request->withWho;
        }
        array_push( $categories, $request->soWhat  );
        array_push( $categories, $request->goWhere );

        $updateCatArray = array();
        foreach ($categories as $category) {
            array_push($updateCatArray, array('activity_id' => $id, 'category_id' => $category));
        }

        DB::table('categories_data')->insert($updateCatArray);

        $activity_id        = $id;
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $updateArray;
        $params['filed']    = ['thumbnail'];
        $params['infix']    = 'activities/';
        $params['suffix']   = "$activity_id/";
        $params['dataX']      = $request->dataX;
        $params['dataY']      = $request->dataY;
        $params['dataHeight'] = $request->dataHeight;
        $params['dataWidth']  = $request->dataWidth;
        $params['dataRotate'] = $request->dataRotate;
        $params['dataScaleX'] = $request->dataScaleX;
        $params['dataScaleY'] = $request->dataScaleY;

        $update             = Library::upload($params);
        $activity           = DB::table('activities')->where('id', $activity_id);
        $result             = $activity->update($update['data']);

        if ($request->status == 3) {
            $mails = DB::table('users')->where('adminer', '>=', 1)->lists('email');
            $msg_system = '<p>Hi 514的同仁</p>
                           <p>活動主 '. Auth::user()->name .' 於514有新增送審的活動，請盡速前往審核</p>
                           <p><a href="' . url('dashboard/activity#tab-4') . '" >後台活動審核連結</a></p>';
            Mail::send('auth.emails.checkout', array('msg' => $msg_system),  function($message) use ($mails, $msg_system, $activity_id) {
                $message->from('service@514.com.tw', '514 活動頻道');
                $message->to( $mails )->subject('【514活動上架審核通知】514活動主'. Auth::user()->name .'新增活動，活動ID：'. $activity_id);
            });
        }

        return Redirect::to('dashboard/activity');
    }

    /**
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $activity = DB::table('activities')->find($id);
        return view('admin.activity.delete', compact('activity'));
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $activities = DB::table('activities')->where('id', $id);
        $activities->delete();
        return Redirect::to('dashboard/activity#tab-1');
    }

    public function showActivity()
    {
        return view('admin.activity.list');
    }

    /**
     * Remove the specified resource from storage.
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
                      'activities.title',    'activities.counter',     'activities.activity_start',   'activities.activity_end',
                      'activities.targets',  'activities.status',      'activities.created_at'

                    ))
                    ->orderBy('activities.created_at', 'DESC');

        if (!Auth::user()->adminer){
            $activities->where('users.id', Auth::id());
        }
       // need to change targets to processing bar

       return Datatables::of($activities)
           ->remove_column('id')
           ->edit_column('status', '@if($status == 1) 編輯中 @elseif($status ==3 ) 審核中 @elseif($status == 4) 已發布 @elseif($status == 2) 已隱藏 @else 已刪除 @endif')
           ->add_column('actions', '
                 <div style="white-space: nowrap;">
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id ) }}}"  class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 活動</a>
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id  . \'/tickets\') }}}" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;票卷</a>
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $id  . \'/tickets/admission\') }}}" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-list"></span> 清單</a>
                 <div data-url="{{{ URL::to(\'dashboard/activity/\' . $id . \'/delete\' ) }}}"  class="btn btn-sm btn-danger" onclick="showColorBox(this)"><span class="glyphicon glyphicon-trash"></span> 刪除</div>
                 <input type="hidden" name="row" value="{{$id}}" id="row">
                 </div>')
           ->make();
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return Response
     */
    public function showCategory()
    {
        return view('admin.activity.category');
    }

    /**
     * Remove the specified resource from storage.
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
     * @return Response
     */
    public function createCategory()
    {
        return view('admin.category.create_edit');
    }

    /**
     * Show the form for creating a new resource.
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
     * @return Response
     */
    public function deleteCategory($id)
    {
        $category = DB::table('categories')->find($id);
        return view('admin.category.delete', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
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
                    ->leftJoin('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
                    ->leftJoin('act_tickets', 'act_tickets.id', '=', 'orders_detail.sub_topic_id')
                    ->leftJoin('activities', 'orders_detail.topic_id', '=', 'activities.id')
                    ->leftJoin('users', 'users.id', '=', 'orders_detail.provider_id')
                    ->select(array(
                        'orders.MerchantOrderNo', 'activities.title', 'orders_detail.sub_topic_name', 'orders_detail.sub_topic_number',
                        DB::raw("CONCAT(act_tickets.ticket_start, ' ', act_tickets.ticket_end) as ticket_time"),
                        'orders.user_email', 'orders.user_phone', 'orders.PayTime', 'orders.status', 'activities.id', 'users.email',
                    ))
                    ->where('orders.user_id', Auth::id())
                    ->orderBy('orders.created_at', 'ASC');

        return Datatables::of($ticket)
            ->remove_column('email')
            ->edit_column('MerchantOrderNo', "<a style='width:100%' href='@if(\$status == 2) {{ url(\"purchase/trade/\$MerchantOrderNo\") }} @else # @endif'>{{ \$MerchantOrderNo }}</a>")
            ->edit_column('id', "<a href='mailto:{{ \$email }}'><div class='btn btn-xs btn-info'>聯絡廠商</div></a>
                                 <a href='mailto:service@514.com.tw'><div class='btn btn-xs btn-danger'>疑難排解</div></a>")
            ->edit_column('title', "<a style='width:100%' href='{{ url(\"activity/\$id\") }}'>{{ \$title }}</a>")
            ->edit_column('status', '
                            {{-- */
                              $orderStatus = array(
                                  0 => "<span class=\"label label-success\">正選擇交易中</span>",
                                  1 => "<span class=\"label label-default\">購買交易失敗</span>",
                                  2 => "<span class=\"label label-primary\">購買交易成功</span>",
                                  3 => "<span class=\"label label-success\">等待 WebATM</span>",
                                  4 => "<span class=\"label label-success\">等待 ATM 轉帳</span>",
                                  5 => "<span class=\"label label-info\">等待超商提票</span>",
                                  6 => "<span class=\"label label-success\">準備超商代繳</span>",
                                  7 => "<span class=\"label label-success\">等待條碼繳費</span>",
                                  8 => "<span class=\"label label-warning\">網頁逾時未繳</span>",
                              );
                              /* --}}
                            {!! $orderStatus[$status] !!}
                            ')
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
        $hosters = DB::table('users')
                      ->leftJoin('activities', 'activities.hoster_id', '=', 'users.id')
                      ->leftJoin('companys',   'companys.user_id',     '=', 'users.id')
                      ->select(array(
                         'companys.id as company_id', 'companys.name as company_name', 'companys.TaxID as TaxID',
                         'users.name', 'companys.contact_name', 'companys.contact_phone', 'companys.contact_email',
                         'companys.ID_path', 'companys.Bank_path',
                         DB::raw('count(*) as activity_cnt'),
                         DB::raw('sum(activities.counter) as view_cnt'), 'users.id',
                      ))
                      ->where('users.hoster', '>=', 1)
                      ->groupBy('users.id');

        return Datatables::of($hosters)
            ->remove_column('company_id')
            ->edit_column('id','<div style="white-space: nowrap;">
                  <!--<a class="btn btn-info btn-sm iframe" href="{{{ url("dashboard/member/".$id) }}}?view=backend" >會員設定<a>-->
                  <a class="btn btn-danger btn-sm" href="{{{ url("dashboard/activity/hoster/".$company_id."/data") }}}">下載資料</a>
                </div>')
            ->make();
    }

    public function getExpertData($id)
    {
        $file = $id . "-" . time(). ".zip";
        $data = DB::table('companys')
                    ->where('id', $id)
                    ->select(array('ID_path', 'Bank_path'))
                    ->first();

        $files = array();
        if(!empty($data->ID_path)) {
            array_push($files, public_path($data->ID_path));
        }

        if(!empty($data->Bank_path)) {
            array_push($files, public_path($data->Bank_path));
        }

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make(storage_path($file))->folder('HosterID_'.$id)
            ->add($files)->close();

        return response()->download(storage_path($file));
    }

    public function askExpert()
    {
        return view('admin.activity.register_expert');
    }

    public function regExpert(Request $request)
    {
        $count = 0;
        $storeArray = array(
          'name'    => $request->CompanyName,
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
            $count ++;
        }
        if (!empty($request->Bank_path)) {
            array_push($params['filed'], 'Bank_path');
            $count ++;
        }

        if ($count) {
            $update = Library::upload($params);
            $result = DB::table('companys')->where('id', $id)
                        ->update($update['data']);
        } else {
            $result = true;
        }

        if ($result) {
            $mails = DB::table('users')->where('adminer', '>=', 1)->lists('email');
            $msg_system = '<p>Hi 514的同仁</p>
                           <p>514會員 '. Auth::user()->name .' 於514平台申請成為活動主，請盡速前往審核</p>
                           <p><a href="' . url('dashboard/member#tab-2') . '" >後台活動主審核區連結</a></p>';
            Mail::send('auth.emails.checkout', array('msg' => $msg_system),  function($message) use ($mails, $msg_system) {
                $message->from('service@514.com.tw', '514 活動頻道');
                $message->to( $mails )->subject('【514活動主申請審核通知】514會員'. Auth::user()->name .'要申請成為活動主');
            });

            $msg_customer = '申請完成，請靜待系統進行審核';
            Mail::send('auth.emails.checkout', array('msg' => $msg_customer),  function($message) use ($msg_customer) {
                $message->from('service@514.com.tw', '514 活動頻道');
                $message->to( Auth::user()->email, Auth::user()->name )->subject('【514活動主申請通知】申請完成，請靜待系統進行審核');
            });

            Session::flash('message', '申請完成，請靜待系統進行審核');
            DB::table('users')
                  ->where('id', Auth::id())
                  ->update(array(
                    'hoster'      => 1,
                    'updated_at'  => date("Y-m-d H:i:s"),
                  ));
        }
        return Redirect::to('dashboard/activity#tab-0');

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
                        'users.name', 'activities.title', 'activities.updated_at',
                        'categories.name as cat_name', 'activities.id',
                      ))
                      ->where('activities.status', 3);

        return Datatables::of($check)
            ->edit_column('id','<div style="white-space: nowrap;">
                  <a class="btn btn-info btn-sm iframe" href="{{{ url("dashboard/activity/".$id. "/priview") }}}" >預覽<a>
                  <div class="btn btn-success btn-sm" onclick="passActivity({{$id}})">通過</div>
                  <div class="btn btn-danger btn-sm iframe" href="{{{ url("dashboard/activity/".$id."/reject") }}}"><span class="glyphicon glyphicon-pencil"></span> 退回</div>
                </div>')
            ->make();
    }

    public function passActivity($id)
    {
        $activity = DB::table('activities')->where('id', $id);
        $activity->update(array(
                      'status' => 4,
                      'activity_start'  => DB::raw('activity_start'),
                    ));

        $user     = DB::table('users')->find($activity->first()->hoster_id);
        $msg_customer = '<p>Hi '. $user->name .'您好，</p>
                       <p>您的活動 '. $activity->first()->title .'，已經通過審核</p>
                       <p><a href="' . url("/activity/$id") . '" >前台活動連結</a></p>';
        Mail::send('auth.emails.checkout', array('msg' => $msg_customer),  function($message) use ($user, $msg_customer, $id) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to( $user->email, $user->name )->subject('【514活動上架審核通知】您舉辦的活動已通過審核，活動ID：'. $id);
        });
    }

    public function showPriview($id)
    {
        $activity = DB::table('activities')
                      ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                      ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                      ->select(array(
                        'activities.id' ,       'activities.title',           'activities.tag_ids',
                        'activities.thumbnail', 'activities.description',     'activities.location',
                        'activities.content',   'activities.activity_start',  'activities.activity_end',
                        'activities.counter',   'activities.category_id',     'activities.max_price',
                        'activities.min_price', 'activities.remark',          'activities.time_range',
                        'categories.name as locat_name',  'users.name as hoster', 'users.nick as nick',
                        'users.avatar as host_photo',   'users.description as host_destricption',
                        'activities.ticket_description', 'activities.fkul', 'activities.hoster_id'
                      ))
                      ->where('activities.id', $id)
                      ->first();

        $tickets = DB::table('act_tickets')
                    ->where('activity_id', $id)
                    ->where('left_over', '>', '0')
                    ->select(array(
                        'id', 'name', 'left_over', 'run_time', 'price', 'ticket_start', 'ticket_end', 'location', 'description'
                    ))
                    ->get();

        $suggests = DB::table('activities')
                      ->leftJoin('categories as cat', 'activities.category_id', '=', 'cat.id')
                      ->leftJoin('categories', 'activities.location_id', '=', 'categories.id')
                      ->where('activities.status', '>=', 4)
                      ->where('activities.category_id', $activity->category_id)
                      ->where('activities.id', '!=', $activity->id)
                      ->select(array(
                        'activities.id',        'activities.thumbnail', 'activities.title',     'activities.description',
                        'activities.location',  'activities.min_price', 'activities.activity_start', 'categories.name as locat_name', 'cat.name as cat_name'
                      ))
                      ->groupBy('activities.title')
                      ->orderBy('activities.created_at', 'ASC')
                      ->take(3)
                      ->get();

        $meta   = array();

        return view('activity.index', compact('meta', 'activity', 'tickets', 'suggests'));
    }

    public function showCheckout()
    {
        return "系統調整中";
        // $tickets = DB::table('act_tickets')
        //             ->leftJoin('activities', 'activities.id', '=', 'act_tickets.activity_id')
        //             ->where('activities.status', '=', 4)
        //             ->whereDate('activities.activity_end', '<', date('Y-m-d'))
        //             ->where('activities.hoster_id', Auth::user()->id)
        //             ->select(array(
        //               'activities.id as activity_id', 'activities.title as activity_name', 'act_tickets.id as ticket_id',
        //               'act_tickets.name as ticket_name', 'act_tickets.left_over', 'act_tickets.total_numbers', 'act_tickets.price',
        //             ))
        //             ->get();

        // 要再想清楚一些

        $orders = DB::table('orders_detail')
                    ->leftJoin('orders', 'orders.id', '=', 'orders_detail.order_id')
                    ->leftJoin('activities', 'activities.id', '=', 'orders_detail.topic_id')
                    ->where('orders_detail.owner_id', Auth::id())
                    ->where('orders_detail.status', 1)
                    ->where('orders.status', 2)
                    ->where('activities.activity_end', '<=', date('Y-m-d H:i:00'));

        $price = 0;

        // $orders_ids = $orders->distinct('orders.id')->lists('orders.id');
        $orders_list    = $orders->lists('orders_detail.id');
        $checkout_price = $orders->sum('InstFirst');

        return $orders->get();
        // foreach ($orders as $order) {
        //     $price  += $order->ticket_price;
        //     $tids    = explode(',' , $order->ticket_id);
        //     $numbers = explode(',' , $order->ticket_number);
        //     foreach ($tids as $key => $ticket_id) {
        //         if (isset($temp[$ticket_id])) {
        //             $temp[$ticket_id] += $numbers[$key];
        //         } else {
        //             $temp[$ticket_id] = $numbers[$key];
        //         }
        //     }
        // }

        foreach ($tickets as $ticket) {
            if (isset($temp[$ticket->ticket_id])) {
                $ticket->sold = $temp[$ticket->ticket_id];
            } else {
                $ticket->sold = 0;
            }
        }

        // update orders
        // update orders_detail
        DB::table('orders_detail')->whereIn('id', $orders_list)->update(array('status' => 2));
        $orders->update(array('status'=>3));

        array(
                'activities.id as activity_id',
                'activities.title as activity_name',
                'act_tickets.id as ticket_id',
                'act_tickets.name as ticket_name',
                'act_tickets.left_over',
                'act_tickets.total_numbers',
                'act_tickets.price',
                'sold'
        );

        return view('admin.activity.checkout', compact('tickets'));
    }

    public function letCheckout()
    {
        $orders = DB::table('orders')
                    ->where('provider_id', Auth::id())
                    ->where('status', 3);
        $price = $orders->sum('ticket_price');
        $mails = DB::table('users')->where('adminer', '>=', 1)->lists('email');
        $msg   = '請匯錢給使用者'.Auth::user()->name. '; 帳號是 '. Auth::user()->bank_name. ' : '. Auth::user()->bank_account . '; 金額:'. intval($price * 0.9);
        Mail::send('auth.emails.checkout', array('msg' => $msg),  function($message) use ($mails, $msg) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to($mails)->subject('催款通知 : '. Auth::user()->name);
        });

        $activities = $orders->groupBy('activity_id')->lists('activity_id');
        DB::table('activities')->whereIn('id', $activities)->update(array('status'=>5));
        $orders->update(array('status' => 4));

        Session::flash('message', '申請完成，請靜待系統進行結清匯款');
        return Redirect::to('dashboard');
    }

    public function getRejectForm($id)
    {
        $provider = DB::table('activities')
                      ->leftJoin('users', 'users.id', '=', 'activities.hoster_id')
                      ->select(array(
                        'activities.title as activity', 'users.id as provider_id', 'users.name', 'users.email', 'users.phone'
                      ))
                      ->where('activities.id', $id)
                      ->first();
        return view('admin.dashboard.reject', compact('provider')) ;
    }

    public function mailToReject(Request $request, $id)
    {
        DB::table('activities')
          ->where('id', $id)
          ->update(array(
              'status'         => 1,
              'updated_at'     => date("Y-m-d H:i:s"),
              'activity_start' => DB::raw('activity_start'),
          ));

        $msg = '<p>活動：'. $request->activity . ', </p><p>回應：' . $request->comment . '</p>';
        DB::table('support_history')
            ->insert(array(
              'customer_id' => $request->provider_id,
              'handler_id'  => Auth::id(),
              'content'     => $msg,
              'position'    => 2,
            ));

        Mail::send('auth.emails.checkout', array('msg' => $msg),  function($message) use ($request) {
            $message->from('service@514.com.tw', '514 活動頻道');
            $message->to($request->email)->subject('【514活動審核通知】'. $request->activity .' 活動審核未過，可以修改或重新編輯後再送審');
        });
    }
}
