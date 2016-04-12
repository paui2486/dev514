<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;

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

class BannerController extends Controller
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
        return view('admin.system.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $AdminTabs = $this->AdminTabs;
        return view('admin.system.banner.create_edit', compact('AdminTabs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $storeArray = array(
            'title'       => $request->title,
            'caption'     => $request->caption,
            'position'    => $request->position,
            'priority'    => $request->priority,
            'position'    => $request->position,
        );

        $id                 = DB::table('galleries')->insertGetId($storeArray);
        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $storeArray;
        $params['filed']    = ['source'];
        $params['infix']    = 'galleries/';
        $params['suffix']   = $request->position . "/";

        $update             = Library::upload($params);
        $banner             = DB::table('galleries')->where('id', $id);
        $result             = $banner->update($update['data']);
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
        $AdminTabs = $this->AdminTabs;
        $banners = DB::table('galleries')->find($id);
        return view('admin.system.banner.create_edit', compact('banners', 'AdminTabs'));
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
        $updateArray = array(
            'title'       => $request->title,
            'caption'     => $request->caption,
            'position'    => $request->position,
            'priority'    => $request->priority,
            'position'    => $request->position,
        );

        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = $updateArray;
        $params['filed']    = ['source'];
        $params['infix']    = 'galleries/';
        $params['suffix']   = $request->position . "/";

        $update             = Library::upload($params);
        $banner             = DB::table('galleries')->where('id', $id);
        $result             = $banner->update($update['data']);
        return Redirect::to('dashboard/system#tab-1');
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
        return Redirect::to('dashboard/system#tab-1');
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
                    ->select(array('id', 'source', 'title', 'caption'))
                    ->orderby('priority', 'ASC');

        return Datatables::of($banners)
            ->remove_column('id')
            ->edit_column('source', '<img src="{{ asset($source) }}" height="100px"></img>')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <a href="{{{ URL::to(\'dashboard/banner/\' . $id ) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
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
        return view('admin.system.banner.delete', compact('banner'));
    }
}
