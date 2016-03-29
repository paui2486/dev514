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
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.filter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Library::getFilter();
        return view('admin.filter.create_edit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    //  public function store(ActivityRequest $request)
     public function store(Request $request)
    {
        $value = null;
        if ( $request->type === 5 ) {
            $value = $request->data;
        } elseif ( $request->type === 6 ) {
            $value = $request->min . "-" . $request->max;
        }

        DB::table('categories')
              ->insert(array(
                  'name'    => $request->name,
                  'type'    => $request->type,
                  'public'  => $request->public,
                  'value'   => $value,
                ));

        return Redirect::to('dashboard/filter');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $filter = DB::table('categories')->find($id);

        if (empty($filter)) {
            return Redirect::back();
        } else {
            $categories = Library::getFilter();
            return view('admin.filter.create_edit', compact('categories', 'filter'));
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
        $value = null;
        if ( $request->type === 5 ) {
            $value = $request->data;
        } elseif ( $request->type === 6 ) {
            $value = $request->min . "-" . $request->max;
        }

        DB::table('categories')
              ->where('id', $id)
              ->update(array(
                  'name'    => $request->name,
                  'type'    => $request->type,
                  'public'  => $request->public,
                  'value'   => $value,
                ));

        return Redirect::to('dashboard/filter');
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $filter = DB::table('categories')->find($id);
        return view('admin.filter.delete', compact('filter'));
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
        return Redirect::to('dashboard/filter');
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
