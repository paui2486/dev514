<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

use DB;
use Log;
use Image;
use Redirect;
use Datatables;
use App\Library;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.member.index');
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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateMemberRequest $request)
    {
        $permission = (array) $request->permission;
        $store = DB::table('users')->insert([
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
        ]);
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
    public function update(UpdateMemberRequest $request, $id)
    {
        $permission = (array) $request->permission;
        $updateArray = array(
          'name'          => $request->name,
          'nick'          => $request->nick,
          'address'       => $request->address,
          'email'         => $request->email,
          'phone'         => $request->phone,
          'bank_name'     => $request->bank_name,
          'bank_account'  => $request->bank_account,
          'adminer'       => in_array('adminer', $permission),
          'author'        => in_array('author', $permission),
          'hoster'        => in_array('hoster', $permission),
          'status'        => $request->status,
          'updated_at'    => date("Y-m-d H:i:s"),
        );

        if (!empty($request->password)) {
            $update['password'] = bcrypt($request->password);
        }

        $user              = DB::table('users')->where('id', $id);
        if (!empty($request->avatar)) {
            $params            = Library::upload_param_template();
            $params['request'] = $request;
            $params['data']    = $updateArray;
            $params['filed']   = ['avatar'];
            $params['infix']   = 'avatar/';
            // $params['suffix']  = "$id-";
            $update            = Library::upload($params);
            $avatar            = public_path($update['data']['avatar']);

            $result            = $user->update($update['data']);
        } else {
            $result            = $user->update($updateArray);
        }

        return Redirect::to('dashboard/member');
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
                    ->select(array('id', 'name', 'email', 'hoster', 'author', 'status'))
                    ->orderBy('created_at', 'ASC');

        return Datatables::of($members)
            // ->remove_column('id')
            ->edit_column('hoster', '@if($hoster == 1) <span class="fa-stack fa-lg">
                  <i class="fa fa-flag fa-stack-1x"></i>
                  </span> @endif')
            ->edit_column('author', '@if($author == 1) <span class="fa-stack fa-lg">
                  <i class="fa fa-flag fa-stack-1x"></i>
                  </span> @endif')
            ->edit_column('status', '@if($status == 0) 未認證 @elseif($status == 1) 已認證 @else 封鎖中  @endif')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <a href="{{{ URL::to(\'dashboard/member/\' . $id ) }}}" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
                  <a href="{{{ URL::to(\'dashboard/member/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> 刪除</a>
                  <input type="hidden" name="row" value="{{$id}}" id="row">
                  </div>')
            ->make();
    }

    /**
     * Reorder items
     *
     * @param items list
     * @return items from @param
     */
    public function getReorder(ReorderRequest $request) {
        $list = $request->list;
        $items = explode(",", $list);
        $order = 1;
        foreach ($items as $value) {
            if ($value != '') {
                ArticleCategory::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
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

    /**
     *
     *
     * @param
     * @return items from @param
     */
    public function searchMember() {
        return view('admin.member.index');
    }

}
