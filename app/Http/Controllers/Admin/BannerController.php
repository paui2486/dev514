<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;

use DB;
use Log;
use Redirect;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.banner.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $store = DB::table('galleries')->insert([
          'title'       => $request->title,
          'source'      => $request->source,
          'caption'     => $request->caption,
          'position'    => $request->position,
          'priority'    => $request->priority,
        ]);
        return Redirect::to('dashboard/banner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $banners = DB::table('galleries')->find($id);
        return view('admin.banner.create_edit', compact('banners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     * 會有一樣的email情況
     */
    public function update(Request $request, $id)
    {
        $user = DB::table('galleries')->where('id', $id);
        $user->update([
          'title'         => $request->title,
          'source'        => $request->source,
          'caption'       => $request->caption,
          'position'      => $request->position,
          'priority'      => $request->priority,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $banner = DB::table('galleries')->where('id', $id);
        $banner->delete();
        return Redirect::to('dashboard/banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function data()
    {
        $banners = DB::table('galleries')
                    ->where('position', 1)
                    ->select(array('id', 'title', 'source', 'caption'))
                    ->orderby('priority', 'ASC');

        return Datatables::of($banners)
            // ->remove_column('id')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <a href="{{{ URL::to(\'dashboard/banner/\' . $id ) }}}?view=colorbox" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
                  <a href="{{{ URL::to(\'dashboard/banner/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
                  <input type="hidden" name="row" value="{{$id}}" id="row">
                  </div>')
            ->make();
    }

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function getDelete($id) {
        $banner = DB::table('galleries')->find($id);
        return view('admin.banner.delete', compact('banner'));
    }
}
