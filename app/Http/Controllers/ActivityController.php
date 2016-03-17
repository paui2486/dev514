<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Log;
use Auth;
use Response;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    //
    public function index()
    {
        return view("activity.index");
    }

    public function Activity()
    {
        return view("activity");
    }

    public function purchase()
    {
        return view("purchase");
    }

    public function getCategory()
    {

    }

    public function showCategory($category)
    {
        // unfinish
        $header_categories  = $this->getCategory();
        $category = DB::table('categories')
                      ->where('name', $category)
                      ->where('type', 1)
                      ->where('public', 1)
                      ->first();

        if (empty($category)) {
            // 無此類別 轉回首頁
            return Redirect::to('blog');
        } else {
            $activity_list = DB::table('activities')
                          ->rightJoin('users', 'users.id', '=', 'activities.host_id')
                          ->select(array(
                            'activities.id',  'activities.title',   'activities.thumbnail',
                            'users.name as author', 'activities.description', 'activities.created_at',
                          ))
                          ->where('activities.category_id', '=' , $category->id )
                          ->paginate(5);
            return view('activity.list', compact('meta', 'header_categories', 'category', 'activity_list'));
        }
    }

    public function showActivity($category, $title)
    {
        $activity = DB::table('activities')
                      ->leftJoin('categories', 'activities.category_id', '=', 'categories.id')
                      ->leftJoin('users', 'users.id', '=', 'activities.host_id')
                      ->where('categories.name', $category)
                      ->where('activities.title', $title)
                      ->select(array(
                        'activities.id' ,       'activities.title',           'activities.tag_ids',
                        'activities.thumbnail', 'activities.description',     'activities.location',
                        'activities.content',   'activities.activity_start',  'activities.activity_end',
                        'activities.counter',   'activities.category_id',     'activities.max_price',
                        'activities.min_price', 'activities.remark',          'activities.time_range',
                        'categories.name as category',  'users.name as hoster', 'users.nick as nick',
                        'users.avatar as host_photo',   'users.description as host_destricption'
                      ))
                      ->where('activities.status', '>=', '2')
                      ->first();

        if (empty($activity)){
            return Redirect::to('');
        } else {
            $tickets = DB::table('act_tickets')
                        ->where('activity_id', $activity->id)
                        ->select(array(
                            'name', 'left_over', 'run_time', 'price', 'ticket_start', 'ticket_end', 'location', 'description'
                        ))
                        ->get();

            $suggests = DB::table('activities')
                          ->where('activities.status', '>=', 2)
                          ->where('activities.category_id', $activity->category_id)
                          ->where('activities.id', '!=', $activity->id)
                          ->select(array(
                            'activities.thumbnail', 'activities.title',     'activities.description',
                            'activities.location',  'activities.min_price', 'activities.activity_start',
                          ))
                          ->groupBy('activities.title')
                          ->orderBy('activities.created_at', 'ASC')
                          ->get();

            DB::table('activities')->where('id', $activity->id)->increment('counter');

            return view('activity.index', compact('activity', 'tickets', 'suggests'));
        }
    }

}
