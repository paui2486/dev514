<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;

use Log;
use DB;
use Datatables;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
          // return view('admin.newscategory.create_edit',compact('newscategory','languages','language'));
          // return json_encode($member);
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
     */
    public function update(MemberRequest $request)
    {
        Log::error($request);
        // return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }

    public function data()
    {
        $members = DB::table('users')
                    ->select(array('id', 'name', 'email', 'hoster', 'author', 'status'))
                    ->orderBy('created_at', 'ASC');

        return Datatables::of($members)
            // ->remove_column('id')
            ->add_column('actions', '
                  <div style="white-space: nowrap;">
                  <a href="{{{ URL::to(\'dashboard/member/\' . $id ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span> 變更</a>
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
}
