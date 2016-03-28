<?php

namespace App;

use Illuminate\Http\Request;

use DB;
use Log;
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

}
