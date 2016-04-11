<?php

namespace App;

use Illuminate\Http\Request;

use DB;
use Log;
use Auth;
use Input;
use Response;
use Redirect;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Library
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function upload_param_template()
    {
        $template = array(
            'data'      => array(),
            'field'     => array(),
            'extension' => '',
            'path'      => '/uploads/',
            'infix'     => '',
            'suffix'    => '',
        );
        return $template;
    }

    public static function upload( $params )
    {
        foreach ($params['filed'] as $filed) {
            if ( $params['request']->hasFile($filed) ) {
                $file                    = $params['request']->file($filed);
                $file_path               = $params['path'] . $params['infix'] . $params['suffix'];
                $file_ext                = $file->getClientOriginalExtension();
                $file_name               = $filed . '-' . time() . '.' . $file_ext ;
                $dest_path               = public_path() . $file_path;
                $move_result             = $file->move($dest_path, $file_name);
                $params['data'][$filed]  = $file_path . $file_name;
            }
        }
        return $params;
    }

    public static function getMeta( $params )
    {
          return ;
    }

    public static function getFilter()
    {
        $categories = array(
            1 => "活動類別",
            3 => "對象類別",
            4 => "地區類別",
            5 => "時間類別",
            6 => "金額類別",
        );
        return $categories;
    }

    public static function getFilterCategory()
    {
        $category = array(
          'what'  => DB::table('categories')
                      ->where('public', 1)
                      ->where('type',   1)->get(),
          'who'   => DB::table('categories')
                      ->where('public', 1)
                      ->where('type',   3)->get(),
          'where' => DB::table('categories')
                      ->where('public', 1)
                      ->where('type',   4)->get(),
        );
        return $category;
    }

    public static function getSlideCategory()
    {
        $slideCategory = DB::table('categories')
                          ->where('public', 1)
                          ->where('type',   1)
                          ->get();
        return $slideCategory;
    }

    public static function getPositionTab( $position, $level = 0 )
    {
        $nav = DB::table('navbars')
                ->where('reverse', 0)
                ->where('position', $position);

        if (!Auth::user()->adminer) {
            $nav = $nav->where('level', '<=', $level);
        }

        $revArray = array(2,3);
        if ($level == 0 && in_array($position, $revArray))
        {
            $reverse = DB::table('navbars')
                        ->where('admin', '<=', Auth::user()->adminer)
                        ->where('reverse', 1)
                        ->where('position', $position);
            $nav = $nav->union($reverse);
        }

        return $nav->get();
    }

    // TODO: delete it
    public static function getAdminTab(Request $request)
    {
        $member   = self::getPositionTab(1);
        // Log::error(Auth::user());
        // $blog     = self::getPositionTab(2, Auth::user()->author);
        // $activity = self::getPositionTab(3, Auth::user()->hoster);

        // $member = array(
        //     0 => array( 'level' => 0, 'url' => 'dashboard/member/profile', 'name' => '個人資料', ),
        //     1 => array( 'level' => 1, 'url' => 'dashboard/member/list',    'name' => '會員列表', ),
        // );
        //
        // // TODO: 還沒開始修改
        // $blog = array(
        //     0 => array( 'level' => 1, 'url' => 'dashboard/blog/create',     'name' => '新增文章',     ),
        //     1 => array( 'level' => 0, 'url' => 'dashboard/blog/list',       'name' => '文章列表',     ),
        //     2 => array( 'level' => 0, 'url' => 'dashboard/blog/register',   'name' => '申請成為達人', ),
        // );
        //
        // $activity = array(
        //     0 => array( 'admin' => 0, 'level' => 1,  'url' => 'dashboard/activity/create',   'name' => '新增活動',      ),
        //     1 => array( 'admin' => 0, 'level' => 1,  'url' => 'dashboard/activity/list',     'name' => '活動列表',      ),
        //     2 => array( 'admin' => 0, 'level' => 2,  'url' => 'dashboard/activity/checkout', 'name' => '收支統計',      ),
        //     3 => array( 'admin' => 0, 'level' => 0,  'url' => 'dashboard/activity/tickets',  'name' => '我的票卷',      ),
        //     4 => array( 'admin' => 1, 'level' => 0,  'url' => 'dashboard/activity/check',    'name' => '審核活動',      ),
        //     5 => array( 'admin' => 0, 'level' => -1, 'url' => 'dashboard/activity/register', 'name' => '申請成為活動主', ),
        // );

        $customer = array();

        $system = array();

        $tabs = array(
            'member'    => $member,
            'blog'      => $blog,
            'activity'  => $activity,
            'customer'  => $customer,
            'system'    => $system,
        );
        return $tabs;
    }

    public static function contactUs()
    {

    }
}
