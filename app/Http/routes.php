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
    Route::get('/'              , 'HomeController@index'        );
    Route::get('About'          , 'PageController@About'        );
    Route::get('Join'           , 'PageController@Joinus'       );
    Route::get('Advertising'    , 'PageController@Advertising'  );
    Route::get('Privacy'        , 'PageController@Privacy'      );
    Route::get('FAQ'            , 'PageController@FAQ'          );
    Route::get('HostGuide'      , 'PageController@HostGuide'   );
    Route::get('PlayGuide'      , 'PageController@PlayGuide'   );
    Route::get('PointUse'       , 'PageController@PointUse'   );
    
    Route::get('MediaReport'    , 'PageController@media-report' );
    Route::get('Partner'        , 'PageController@partner'      );
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

// no yet
        Route::get('filter'                 , 'AdminController@showMember'    );
        Route::get('banner'                 , 'AdminController@showMember'    );
        Route::get('ad'                     , 'AdminController@showMember'    );
        Route::get('point'                  , 'AdminController@showMember'    );
        Route::get('coupon'                 , 'AdminController@showMember'    );
        Route::get('invoice'                , 'AdminController@showMember'    );
        Route::get('analysis'               , 'AdminController@showMember'    );


        Route::get('member/search'          , 'MemberController@searchMember' );
        // Route::get('member/data/reorder'    , 'MemberController@getReorder'   );
        Route::get('member/data'            , 'MemberController@data'         );
        Route::get('member/{id}/delete'     , 'MemberController@getDelete'    );
        Route::post('member/{id}/update'    , 'MemberController@update'       );
        Route::resource('member'            , 'MemberController'              );

        Route::get('blog/data'                  , 'BlogController@data'           );
        Route::get('blog/category'              , 'BlogController@showCategory'   );
        Route::post('blog/category'             , 'BlogController@storeCategory'  );
        Route::get('blog/category/{id}'         , 'BlogController@getCategory'    );
        Route::post('blog/category/{id}/update' , 'BlogController@updateCategory' );
        Route::get('blog/category/{id}/delete'  , 'BlogController@deleteCategory' );
        Route::post('blog/category/{id}/delete' , 'BlogController@destoryCategory');
        Route::get('blog/category/data'         , 'BlogController@getCategoryData');
        Route::get('blog/category/create'       , 'BlogController@createCategory' );

        Route::get('blog/expert'                , 'BlogController@showExpert'     );
        Route::get('blog/expert/data'           , 'BlogController@getExpert'      );
        Route::get('blog/{id}/delete'           , 'BlogController@getDelete'      );
        Route::post('blog/{id}/update'          , 'BlogController@update'         );
        Route::resource('blog'                  , 'BlogController'                );

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
