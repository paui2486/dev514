<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::pattern('id'         , '[0-9]+'      );
Route::pattern('slug'       , '[0-9a-z-_]+' );
Route::pattern('category'   , '[0-9a-z-_]+' );
Route::pattern('username'   , '[0-9a-z-_]+' );

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {

/*
|--------------------------------------------------------------------------
| Static Page
|--------------------------------------------------------------------------
*/
    Route::get('/'              , 'MainController@index'        );
    Route::get('about'          , 'PageController@about'        );
    Route::get('join'           , 'PageController@join'         );
    Route::get('advertising'    , 'PageController@advertising'  );
    Route::get('media-report'   , 'PageController@media_report' );
    Route::get('privacy'        , 'PageController@privacy'      );
    Route::get('faq'            , 'PageController@faq'          );
    Route::get('partner'        , 'PageController@partner'      );
    Route::get('host-guide'     , 'PageController@host-guide'   );
    Route::get('play-guide'     , 'PageController@play-guide'   );

/*
|--------------------------------------------------------------------------
| Dynamic Routes
|--------------------------------------------------------------------------
*/
    Route::auth();

    Route::get('members/{username}'         , 'UserController@index'          );

    Route::get('activity'                   , 'ActivityController@index'      );
    Route::get('activity/{category}/{slug}' , 'ActivityController@index'      );

    Route::get('blog'                       , 'BlogController@index'          );
    Route::get('blog/{category}'            , 'BlogController@index'          );
    Route::get('blog/{category}/{slug}'     , 'BlogController@index'          );

    Route::get('order/{id}'                 , 'CartController@index'          );

    Route::get('master'                     , 'UserController@index'          );

    Route::get('redirect'                   , 'SocialAuthController@redirect' );
    Route::get('callback'                   , 'SocialAuthController@callback' );

    Route::get('profile'                    , 'AuthController@profile'        );
    // Route::get('profile/edit');

    Route::get('follows'                    , 'AuthController@follows'        );
    Route::get('friends'                    , 'AuthController@friends'        );
    Route::get('activitys'                  , 'AuthController@activitys'      );

    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {

        Route::get('/'                      , 'AdminController@index'         );
        Route::get('member/search'          , 'MemberController@searchMember' );
        Route::get('member/data/reorder'    , 'MemberController@getReorder'   );
        Route::get('member/data'            , 'MemberController@data'         );
        Route::post('member/{id}/update'            , 'MemberController@update'         );
        Route::resource('member'            , 'MemberController'              );

// no yet
        Route::get('filter'                 , 'AdminController@showMember'    );
        Route::get('banner'                 , 'AdminController@showMember'    );
        Route::get('ad'                     , 'AdminController@showMember'    );
        Route::get('point'                  , 'AdminController@showMember'    );
        Route::get('coupon'                 , 'AdminController@showMember'    );
        Route::get('invoice'                , 'AdminController@showMember'    );
        Route::get('analysis'               , 'AdminController@showMember'    );

        Route::get('blog'                   , 'AdminController@showMember'    );
        Route::get('blog/create'            , 'AdminController@showMember'    );
        Route::get('blog/category'          , 'AdminController@showMember'    );
        Route::get('blog/expert'            , 'AdminController@showMember'    );

        Route::get('activity'               , 'AdminController@showMember'    );
        Route::get('activity/create'        , 'AdminController@showMember'    );
        Route::get('activity/category'      , 'AdminController@showMember'    );
        Route::get('activity/hoster'        , 'AdminController@showMember'    );
        Route::get('activity/coupon'        , 'AdminController@showMember'    );
        Route::get('activity/invoice'       , 'AdminController@showMember'    );

        Route::get('customer'               , 'AdminController@showMember'    );
        Route::get('customer/wait'          , 'AdminController@showMember'    );
        Route::get('customer/handle'        , 'AdminController@showMember'    );
        Route::get('customer/finish'        , 'AdminController@showMember'    );
        // Route::resource('banner');
        // Route::resource('event');
        // Route::resource('member');
        // Route::resource('supplier');
        // Route::resource('category');
        // Route::resource('activity');
        // Route::resource('blogger');
        // Route::resource('customer');
        // Route::resource('coupon');
        // Route::resource('point');
        // Route::resource('analysis');
        // Route::resource('system');
    });
});

/*
 * issue
 *    read more: 1.new blogs. 2. activities by category. 3. IM chat
 */
