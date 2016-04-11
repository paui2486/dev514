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
            return view('admin.ticket.index', compact('id'));
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
                 <a href="{{{ URL::to(\'dashboard/activity/\' . $activity_id . \'/tickets/\' . $id .  \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
                 <input type="hidden" name="row" value="{{$id}}" id="row">
                 </div>')
           ->make();
    }
}
