<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

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

class SystemController extends Controller
{
    protected $AdminTabs;
    public function __construct()
    {
        if( Auth::check() ) {
            $this->AdminTabs = Library::getPositionTab(5);
        }
    }

    public function index()
    {
        $AdminTabs = $this->AdminTabs;
        return view('admin.system.index', compact('AdminTabs'));
    }

    public function listTarget($target)
    {
        $AdminTabs = $this->AdminTabs;
        return view('admin.system.'. $target .'.index');
    }
}
