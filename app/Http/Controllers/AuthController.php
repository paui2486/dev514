<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Input;
use Session;
use Redirect;
use Response;
use App\Library;
use App\Http\Requests;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('');
    }

    public function follows()
    {
        return view('auth.pages.follows');
    }

    public function friends()
    {
        return view('auth.pages.friends');
    }

    public function activitys()
    {
        return view('auth.pages.activitys');
    }

    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function registerExp()
    {
        return view("page.reg_expert");
    }

    public function submitRegister(Request $request)
    {
      // {
          // _token: "Koenbd9D3BezrsPDkT0SNAdoS9rHCHpPttBRbZKD",
          // dataX_avatar: "", dataY_avatar: "",
          // dataH_avatar: "", dataW_avatar: "",
          // dataR_avatar: "", dataSX_avatar: "",
          // dataSY_avatar: "",
          // name: "Lance Li", experience: "123,4124",
          // phone: "0919173037", phone_s: "1",
          // mobile: "0919173037", mobile_s: "1",
          // email: "lamon0624@gmail.com", email_s: "1",
          // line: "12313", line_s: "1",
          // address: "gg", address_s: "1",
          // links: [ "123123", "123", "" ],
          // reg_name: "Lance Li", reg_phone: "14512",
          // reg_address: "gg",
          // company_VAT: "", company_address: "gg",
          // contact_name: "Lance Li", contact_phone: "0919173037",
          // invisible: "1",
          // ID_path: { },
          // bank_path: { }
      // }
        $user_id = Auth::id();
        $user_ex = DB::table('users_extend');
        $date    = date("Y-m-d H:i:s");

        $params             = Library::upload_param_template();
        $params['request']  = $request;
        $params['data']     = array();
        $params['filed']    = ['avatar', 'ID_path', 'bank_path', 'cID_path', 'cbank_path'];
        $params['infix']    = 'avatar/';
        $params['suffix']   = "$user_id/";

        $params = Library::upload($params);

        $RegularInsert = array(
          array('user_id' => $user_id, 'attribute' => '_ExpName',   'value' => $request->name, 'status' => 1, 'created_at' => $date),
          array('user_id' => $user_id, 'attribute' => '_ExpExp',    'value' => $request->experience, 'status' => 1, 'created_at' => $date),
          array('user_id' => $user_id, 'attribute' => '_ExpPhone',  'value' => $request->phone, 'status' => $request->phone_s, 'created_at' => $date),
          array('user_id' => $user_id, 'attribute' => '_ExpMobile', 'value' => $request->mobile, 'status' => $request->mobile_s, 'created_at' => $date),
          array('user_id' => $user_id, 'attribute' => '_ExpEmail',  'value' => $request->email, 'status' => $request->email_s, 'created_at' => $date),
          array('user_id' => $user_id, 'attribute' => '_ExpLine',   'value' => $request->line, 'status' => $request->line_s, 'created_at' => $date),
          array('user_id' => $user_id, 'attribute' => '_ExpAddr',   'value' => $request->address, 'status' => $request->address_s, 'created_at' => $date),
        );

        foreach ($request->links as $link) {
            $linkInsert  = array('user_id' => $user_id, 'attribute' => '_ExpLinks', 'value' => $link, 'status' => 1, 'created_at' => $date);
            array_push($RegularInsert,$linkInsert);
        }

        if ( isset($params['data']['avatar']) ) {
            $avatarInsert  = array('user_id' => $user_id, 'attribute' => '_ExpAvatar', 'value' => $params['data']['avatar'], 'status' => 1, 'created_at' => $date);
            array_push($RegularInsert,$avatarInsert);
        }

        switch ($request->invisible) {
            // personal
            case '1':
                $invisible = array(
                  array('user_id' => $user_id, 'attribute' => '_RegName',   'value' => $request->reg_name, 'status' => 1, 'created_at' => $date),
                  array('user_id' => $user_id, 'attribute' => '_RegPhone',  'value' => $request->reg_phone, 'status' => 1, 'created_at' => $date),
                  array('user_id' => $user_id, 'attribute' => '_RegAddr',   'value' => $request->reg_address, 'status' => 1, 'created_at' => $date),
                );
                if ( isset($params['data']['ID_path']) ) {
                    $pathInsert  = array('user_id' => $user_id, 'attribute' => '_ExpID', 'value' => $params['data']['ID_path'], 'status' => 1, 'created_at' => $date);
                    array_push($invisible,$pathInsert);
                }
                if ( isset($params['data']['bank_path']) ) {
                    $pathInsert  = array('user_id' => $user_id, 'attribute' => '_ExpBank', 'value' => $params['data']['bank_path'], 'status' => 1, 'created_at' => $date);
                    array_push($invisible,$pathInsert);
                }
                break;

            // company
            case '2':
                $invisible = array(
                  array('user_id' => $user_id, 'attribute' => '_ComVAT',   'value' => $request->reg_name, 'status' => 1, 'created_at' => $date),
                  array('user_id' => $user_id, 'attribute' => '_ComAddr',  'value' => $request->reg_phone, 'status' => 1, 'created_at' => $date),
                  array('user_id' => $user_id, 'attribute' => '_CntNmae',  'value' => $request->reg_address, 'status' => 1, 'created_at' => $date),
                  array('user_id' => $user_id, 'attribute' => '_CntPhone', 'value' => $request->reg_name, 'status' => 1, 'created_at' => $date),
                );
                if ( isset($params['data']['cID_path']) ) {
                    $pathInsert  = array('user_id' => $user_id, 'attribute' => '_ComID', 'value' => $params['data']['cID_path'], 'status' => 1, 'created_at' => $date);
                    array_push($invisible,$pathInsert);
                }
                if ( isset($params['data']['cbank_path']) ) {
                    $pathInsert  = array('user_id' => $user_id, 'attribute' => '_ComBank', 'value' => $params['data']['cbank_path'], 'status' => 1, 'created_at' => $date);
                    array_push($invisible,$pathInsert);
                }
                break;

            // hidden
            default:
                break;
        }

        $remove = DB::table('users_extend')->where('user_id', $user_id)->delete();
        $RegisterArray = array_merge($RegularInsert,$invisible);
        $result = DB::table('users_extend')->insert($RegisterArray);

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
}
