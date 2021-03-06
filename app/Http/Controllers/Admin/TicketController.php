<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use DB;
use Log;
use Auth;
use Input;
use Image;
use Session;
use Response;
use Redirect;
use Datatables;
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
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
     *
     * @return Response
     */
    public function index($id)
    {
        $AdminTabs = $this->AdminTabs;
        if ( Auth::user()->adminer ) {
            return view('admin.ticket.index', compact('id', 'AdminTabs'));
        } else {
            $act_info = DB::table('activities')
                          ->where('id', $id)
                          ->where('hoster_id', Auth::id())
                          ->first();
            if (empty($act_info)) {
                return Redirect::to('/');
            } else {
                return view('admin.ticket.index', compact('id', 'act_info', 'AdminTabs'));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $AdminTabs = $this->AdminTabs;

        $act_info = DB::table('activities')->find($id);
        if ( empty($act_info) ) {
            return Redirect::to('/');
        } else {
            if ( Auth::user()->adminer || $act_info->hoster_id === Auth::id() ) {
                return view('admin.ticket.create_edit', compact('id', 'act_info', 'AdminTabs'));
            } else {
                return Redirect::to('/');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, $activity_id)
    {
        $act_info = DB::table('activities')->find($activity_id);
        if ( empty($act_info) ) {
            return Redirect::to('/');
        } else {
            if ( Auth::user()->adminer || $act_info->hoster_id === Auth::id() ) {

                $storeArray = array(
                    'ticket_start'  => $request->ticket_start_date. " " . $request->ticket_start_time,
                    'ticket_end'    => $request->ticket_end_date.   " " . $request->ticket_end_time,
                    'sale_start'    => $request->sale_start_date.   " " . $request->sale_start_time,
                    'sale_end'      => $request->sale_end_date.     " " . $request->sale_end_time,
                    'activity_id'   => $activity_id,
                    'location'      => $act_info->location,
                    'name'          => $request->name,
                    'status'        => $request->status,
                    'price'         => $request->price,
                    'description'   => $request->description,
                    'left_over'     => $request->total_numbers,
                    'total_numbers' => $request->total_numbers,
                );

                $this->priceCompare($act_info, $request);

                $result = DB::table('act_tickets')->insert($storeArray);
                return Redirect::to('/dashboard/activity/'.$activity_id.'/tickets');
            } else {
                return Redirect::to('/');
            }
        }
        return Response::json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $ticket_id)
    {
        $AdminTabs = $this->AdminTabs;

        $act_info = DB::table('activities')->find($id);
        if ( empty($act_info) ) {
            return Redirect::to('/');
        } else {
            if ( Auth::user()->adminer || $act_info->hoster_id === Auth::id() ) {
                $ticket = DB::table('act_tickets')->find($ticket_id);
                return view('admin.ticket.create_edit', compact('id', 'act_info', 'ticket', 'AdminTabs'));
            } else {
                return Redirect::to('/');
            }
        }
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
    public function update(Request $request, $id, $ticket_id)
    {
        $act_info = DB::table('activities')->find($id);
        if ( empty($act_info) ) {
            return Redirect::to('/');
        } else {
            if ( Auth::user()->adminer || $act_info->hoster_id === Auth::id() ) {
                $ticket = DB::table('act_tickets')->where('id', $ticket_id)->first();
                $left_over = $ticket->left_over + $request->total_numbers - $ticket->total_numbers;
                if ( $left_over < 0) {
                    Session::flash('message', '系統出現錯誤，由於你設定的票卷數遠少於已售出的票數，所以此次更新無效');
                    return Redirect::to('dashboard/activity/'. $id .'/tickets');
                }

                $updateArray  = array(
                    'name'          => $request->name,
                    'status'        => $request->status,
                    'price'         => $request->price,
                    'description'   => $request->description,
                    'total_numbers' => $request->total_numbers,
                    'left_over'     => $left_over,
                    'ticket_start'  => $request->ticket_start_date. " " . $request->ticket_start_time,
                    'ticket_end'    => $request->ticket_end_date.   " " . $request->ticket_end_time,
                    'sale_start'    => $request->sale_start_date.   " " . $request->sale_start_time,
                    'sale_end'      => $request->sale_end_date.     " " . $request->sale_end_time,
                );

                $this->priceCompare($act_info, $request);

                $result       = DB::table('act_tickets')->where('id', $ticket_id)->update($updateArray);
                return Redirect::to('dashboard/activity/'. $id .'/tickets');
            } else {
                return Redirect::to('/');
            }
        }
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($category, $id) {
      // 需增加 假如票卷只有一張，無法刪除
        $tickets = DB::table('act_tickets')->find($id);
        return view('admin.ticket.delete', compact('tickets', 'id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($category, $id)
    {
        $ticket = DB::table('act_tickets')->where('id', $id);
        $ticket->delete();
        return Redirect::to('dashboard/activity/' . $category . '/tickets/' . $id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function data($event_id)
    {
        $tickets = DB::table('act_tickets')
                    ->leftJoin('activities', 'activities.id', '=', 'act_tickets.activity_id')
                    ->select(array(
                        'activities.id as activity_id',   'act_tickets.id',                 'activities.title',    'act_tickets.name',
                        'act_tickets.total_numbers',      'act_tickets.left_over as left',  'act_tickets.price',  'act_tickets.status',
                    ))
                    ->where('activities.id', $event_id)
                    ->orderBy('activities.title', 'ASC');

       // need to change targets to processing bar
       return Datatables::of($tickets)
           ->remove_column('id', 'activity_id')
           ->edit_column('status', '@if($status == 1) 發售中 @elseif($status == 2) 停售中 @elseif($status == 3) 已隱藏 @else 已刪除 @endif')
           ->add_column('actions', '
                 <div style="white-space: nowrap;">
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $activity_id  . \'/tickets/\' . $id) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 調整</a>
                 <div data-url="{{{ URL::to(\'dashboard/activity/\' . $activity_id . \'/tickets/\' . $id .  \'/delete\' ) }}}" class="btn btn-sm btn-danger" onclick="showColorBox(this)"><span class="glyphicon glyphicon-trash"></span> 刪除</div>
                 <input type="hidden" name="row" value="{{$id}}" id="row">
                 </div>')
           ->make();
    }

    public function showList($id)
    {
        $AdminTabs = $this->AdminTabs;
        return view('admin.activity.ticket_list', compact('AdminTabs'));
    }


    public function getList($id)
    {
        $solds = DB::table('orders')
                  ->leftJoin('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
                  ->select(array(
                      'orders.MerchantOrderNo', 'orders.user_name', 'orders.user_email', 'orders.user_phone',
                      'orders_detail.sub_topic_name',  'orders_detail.sub_topic_number', 'orders_detail.sub_topic_price', 'orders.PayTime', 'orders.status'
                  ))
                  ->where('orders_detail.topic_id', $id)
                  ->orderBy('orders.PayTime', 'ASC');

        return Datatables::of($solds)
            ->add_column('event','')
            ->edit_column('MerchantOrderNo', "<a style='width:100%' href='@if(\$status == 2) {{ url(\"purchase/trade/\$MerchantOrderNo\") }} @else # @endif'>{{ \$MerchantOrderNo }}</a>")
            ->edit_column('status', '{{-- */
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
                                     {!! $orderStatus[$status] !!}')
            ->make();
    }

    private function priceCompare($act_info, $request)
    {
        $prices = DB::table('act_tickets')->where('activity_id', $act_info->id)->lists('price');
        $max    = max($prices);
        $min    = min($prices);
        $price  = $request->price;
        if ( $price != $max ) {
            DB::table('activities')->where('id', $act_info->id)
                ->update(Array(
                        'activity_start' => $act_info->activity_start,
                        'max_price'      => $price,
                ));
        }
        if ( $price != $min ) {
            DB::table('activities')->where('id', $act_info->id)
                ->update(Array(
                        'activity_start' => $act_info->activity_start,
                        'min_price'      => $price,
                ));
        }
        return true;
    }
}
