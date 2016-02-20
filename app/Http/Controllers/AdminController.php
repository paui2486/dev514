<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $state = (object) array(
            'Blogs'     => (object) array(
                'count' => 0,
                'color' => 'terques',
                'icon'  => 'fa-user',
            ),
            'Users'     => (object) array(
                'count' => 0,
                'color' => 'red',
                'icon'  => 'fa-tags',
            ),
            'Activitys' => (object) array(
                'count' => 0,
                'color' => 'yellow',
                'icon'  => 'fa-shopping-cart',
            ),
            'Total PVs' => (object) array(
                'count' => 0,
                'color' => 'blue',
                'icon'  => 'fa-bar-chart-o',
            )
        );

        return view('admin.dashboard.index', compact('state'));
    }

}
