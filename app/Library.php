<?php

namespace App;

use Illuminate\Http\Request;

use DB;
use Log;
use Auth;
use Input;
use Image;
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

    public static function upload( $params, $name = null )
    {
        $data = ['dataX', 'dataY', 'dataH', 'dataW', 'dataR', 'dataSX', 'dataSY'];
        foreach ($params['filed'] as $field) {
            if ( $params['request']->hasFile($field) ) {
                $file       = $params['request']->file($field);
                $file_path  = $params['path'] . $params['infix'] . $params['suffix'];
                $file_ext   = $file->getClientOriginalExtension();
                $file_name  = $field . '-' . time() . '.' . $file_ext ;
                $dest_path  = public_path() . $file_path;
                $height     = 1080;
                $width      = null;
                $quality    = 90;

                foreach ($data as $name) {
                    $$name = $name."_".$field;
                    $params[$name] = $params['request']->$$name;
                }

                if (!file_exists($dest_path)) {
                    mkdir($dest_path, 0777);
                }

                if (isset($params['height'])) {
                      $height = $params['height'];
                      $width  = $params['width'];
                }

                $img = Image::make($file);

                if (isset($params['dataW'])) {
                    $img -> crop($params['dataW'], $params['dataH'], $params['dataX'], $params['dataY'] );
                }

                $img -> resize($height, $width, function($constraint) {
                    $constraint -> aspectRatio();
                    $constraint -> upsize();
                });
                $img -> save($dest_path.$file_name, $quality);
                $params['data'][$field]  = $file_path . $file_name;
            // } else {
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
            2 => "文章類別",
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
        $slideCategory = DB::table('categories')//變數 slideCategory 有點像SQL 到DB 514_dev底下這張表categories
                          ->where('public', 1)//當public = 1
                          ->get(); //抓出來
        return $slideCategory; //傳送回$slideCategory
    }

    public static function getPositionTab( $position, $level = 0 )
    {
        $nav = DB::table('navbars')
                ->where('admin', '<=', Auth::user()->adminer)
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

    public static function contactUs()
    {

    }
}
