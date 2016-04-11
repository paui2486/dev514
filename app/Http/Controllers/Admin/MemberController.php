<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

use DB;
use Log;
use Auth;
use Image;
use Input;
use Redirect;
use Datatables;
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    protected $AdminTabs;
    public function __construct()
    {
        $this->AdminTabs = Library::getPositionTab(1);
    }

    public function index()
    {
        $AdminTabs = $this->AdminTabs;
        return view('admin.member.index', compact('AdminTabs'));
    }

    public function profile()
    {
        // For AJAX
        $member = Auth::user();
        return view('admin.member.create_edit', compact('member'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.member.create_edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showMember()
    {
        // For AJAX
        return view('admin.member.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $permission = (array) $request->permission;
        $storeArray = array(
          'name'          => $request->name,
          'nick'          => $request->nick,
          'password'      => bcrypt($request->password),
          'address'       => $request->address,
          'email'         => $request->email,
          'phone'         => $request->phone,
          'bank_name'     => $request->bank_name,
          'bank_account'  => $request->bank_account,
          'adminer'       => in_array('adminer', $permission),
          'author'        => in_array('author', $permission),
          'hoster'        => in_array('hoster', $permission),
          'status'        => $request->status,
          'created_at'    => date("Y-m-d H:i:s"),
          'updated_at'    => date("Y-m-d H:i:s"),
        );

        if (!empty($request->avatar)) {
            $params            = Library::upload_param_template();
            $params['request'] = $request;
            $params['data']    = $storeArray;
            $params['filed']   = ['avatar'];
            $params['infix']   = 'avatar/';
            $update            = Library::upload($params);
            $result            = DB::table('users')->insert($update['data']);
        } else {
            $result            = DB::table('users')->insert($storeArray);
        }
        return Redirect::to('dashboard/member');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $member = DB::table('users')->find($id);
        return view('admin.member.create_edit', compact('member'));
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
        if( Auth::user()->adminer || Auth::user()->id == $id) {
            $permission = (array) $request->permission;
            $updateArray = array(
              'name'          => $request->name,
              'nick'          => $request->nick,
              'address'       => $request->address,
              'email'         => $request->email,
              'phone'         => $request->phone,
              'bank_name'     => $request->bank_name,
              'bank_account'  => $request->bank_account,
              'status'        => $request->status,
              'updated_at'    => date("Y-m-d H:i:s"),
            );

            if ( Auth::user()->adminer ) {
               $updateArray['adminer'] = in_array('adminer', $permission);
               $updateArray['author']  = in_array('author', $permission);
               $updateArray['hoster']  = in_array('hoster', $permission);
            }

            if (!empty($request->password)) {
                $update['password'] = bcrypt($request->password);
            }
            // return Input::all();
            $user              = DB::table('users')->where('id', $id);
            if (!empty($request->avatar)) {
                $params            = Library::upload_param_template();
                $params['request'] = $request;
                $params['data']    = $updateArray;
                $params['filed']   = ['avatar'];
                $params['infix']   = 'avatar/';
                $update            = Library::upload($params);
                $result            = $user->update($update['data']);
            } else {
                $result            = $user->update($updateArray);
            }

            if ( Auth::user()->adminer ) {
                return Redirect::to('dashboard/member');
            }
            return Redirect::back();
        } else {
            return Redirect::to();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = DB::table('users')->where('id', $id);
        $user->delete();
        return Redirect::to('dashboard/member');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function data()
    {
        $members = DB::table('users')
                    ->select(array('id', 'name', 'email', 'adminer', 'hoster', 'author', 'status'))
                    ->orderBy('created_at', 'ASC');

        return Datatables::of($members)
            ->remove_column('id')
            ->edit_column('adminer', '@if($adminer == 1) <span class="fa-stack fa-lg">
                  <i class="fa fa-flag fa-stack-1x"></i>
                  </span> @endif')
            ->edit_column('hoster', '@if($hoster == 1) 申請中 @elseif($hoster == 2) 已核可 @endif')
            ->edit_column('author', '@if($author == 1) 申請中 @elseif($author == 2) 已核可 @endif')
            ->edit_column('status', '@if($status == 0) 未認證 @elseif($status == 1) 已認證 @else 封鎖中  @endif')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <div data-url="{{{ URL::to(\'dashboard/member/\' . $id ) }}}" onclick="edit(this)" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 變更</div>
                  <a href="{{{ URL::to(\'dashboard/member/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
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
        $member = DB::table('users')->find($id);
        return view('admin.member.delete', compact('member'));
    }
}
