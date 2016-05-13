<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

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

class FilterController extends Controller
{
    protected $AdminTabs;
    public function __construct()
    {
        if( Auth::check() ) {
            $this->AdminTabs = Library::getPositionTab(5);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.system.filter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $AdminTabs  = $this->AdminTabs;
        $categories = Library::getFilter();
        return view('admin.system.filter.create_edit', compact('categories', 'AdminTabs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    //  public function store(ActivityRequest $request)
     public function store(Request $request)
    {
        $value = "";
        if ( $request->type == 5 ) {
            $value = $request->value;
        } elseif ( $request->type == 6 ) {
            $value = $request->max;
        } elseif ( $request->type == 1 ) {
            $value = $request->value;
        }

        $storeArray = array(
            'name'    => $request->name,
            'type'    => $request->type,
            'public'  => $request->public,
            'value'   => $value,
        );

        DB::table('categories')->insert($storeArray);

        return Redirect::to('dashboard/system#tab-0');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $AdminTabs = $this->AdminTabs;
        $filter = DB::table('categories')->find($id);

        if (empty($filter)) {
            return Redirect::back();
        } else {
            $categories = Library::getFilter();
            return view('admin.system.filter.create_edit', compact('categories', 'filter', 'AdminTabs'));
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
    public function update(Request $request, $id)
    {
        $value = "";
        if ( $request->type == 5 ) {
            $value = $request->value;
        } elseif ( $request->type == 6 ) {
            $value = $request->min . "-" . $request->max;
        } elseif ( $request->type == 1 ) {
            $value = $request->value;
        }

        DB::table('categories')
              ->where('id', $id)
              ->update(array(
                  'name'    => $request->name,
                  'type'    => $request->type,
                  'public'  => $request->public,
                  'value'   => $value,
                ));

        return Redirect::to('dashboard/system#tab-0');
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $filter = DB::table('categories')->find($id);
        return view('admin.system.filter.delete', compact('filter'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $categories = DB::table('categories')->where('id', $id);
        $categories->delete();
        return Redirect::to('dashboard/system#tab-0');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function data()
    {
        $categories = DB::table('categories')
                        ->select(array(
                          'id', 'name', 'type', 'public', 'priority',
                        ))
                        ->whereIn('type', array(1,3,4,5,6))
                        ->orderBy('priority', 'ASC')
                        ->orderBy('name',     'ASC');

       return Datatables::of($categories)
                ->remove_column('id')
                ->edit_column('type', '@if($type == 1) 活動類別 @elseif($type == 3 ) 對象類別 @elseif($type == 4) 地區類別 @elseif($type == 5) 時間類別 @elseif($type == 6) 金額類別 @else 蝦咪類別 @endif')
                ->edit_column('public', '@if($public == 1) 顯示 @elseif($public == 0 ) 隱藏 @else 已刪除 @endif')
                ->edit_column('priority', '
                     <div style="white-space: nowrap;">
                     <a href="{{{ URL::to(\'dashboard/filter/\' . $id ) }}}"                class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 修改 </a>
                     <a href="{{{ URL::to(\'dashboard/filter/\' . $id . \'/delete\' ) }}}"  class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除 </a>
                     <input type="hidden" name="row" value="{{$id}}" id="row">
                     </div>')
                ->make();
    }
}
