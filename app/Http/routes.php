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
// Route::pattern('slug'       , '[0-9a-z-_]+' );
// Route::pattern('category'   , '[0-9a-z-_]+' );
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

    Route::get('activity'                   , 'ActivityController@Activity'      );
    Route::get('activity/{category}/{slug}' , 'ActivityController@Activity'      );

    Route::get('blog'                       , 'ArticleController@index'       );
    Route::get('blog/{category}'            , 'ArticleController@showCategory');
    Route::get('blog/{category}/{slug}'     , 'ArticleController@showArticle' );

    Route::get('order/{id}'                 , 'CartController@index'          );

    Route::get('master'                     , 'UserController@index'          );

    Route::get('redirect'                   , 'SocialAuthController@redirect' );
    Route::get('callback'                   , 'SocialAuthController@callback' );

    Route::get('follows'                    , 'AuthController@follows'        );
    Route::get('friends'                    , 'AuthController@friends'        );
    Route::get('activitys'                  , 'AuthController@activitys'      );
    Route::get('dashboard'                  , 'Admin\AdminController@index'         );
    Route::get('dashboard/profile'          , 'AuthController@profile'        );

    // for author
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'author'], function() {
        Route::get('blog/data'                  , 'BlogController@data'           );
        Route::get('blog/{id}/delete'           , 'BlogController@getDelete'      );
        Route::post('blog/{id}/update'          , 'BlogController@update'         );
        Route::resource('blog'                  , 'BlogController'                );
    });

    // for host
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'host'], function() {
        Route::get('activity/data'              , 'ActivityController@data'       );
        Route::get('activity/{id}/delete'       , 'ActivityController@getDelete'  );
        Route::post('activity/{id}/update'      , 'ActivityController@update'     );
        Route::resource('activity'              , 'ActivityController'            );

    });

    // for admin
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {

        Route::get('banner/data'                    , 'BannerController@data'             );
        Route::get('banner/{id}/delete'             , 'BannerController@getDelete'        );
        Route::post('banner/{id}/update'            , 'BannerController@update'           );
        Route::resource('banner'                    , 'BannerController'                  );

        Route::get('member/search'                  , 'MemberController@searchMember'     );
        Route::get('member/data'                    , 'MemberController@data'             );
        Route::get('member/{id}/delete'             , 'MemberController@getDelete'        );
        Route::post('member/{id}/update'            , 'MemberController@update'           );
        Route::resource('member'                    , 'MemberController'                  );

        Route::get('blog/category'                  , 'BlogController@showCategory'       );
        Route::post('blog/category'                 , 'BlogController@storeCategory'      );
        Route::get('blog/category/{id}'             , 'BlogController@getCategory'        );
        Route::post('blog/category/{id}/update'     , 'BlogController@updateCategory'     );
        Route::get('blog/category/{id}/delete'      , 'BlogController@deleteCategory'     );
        Route::post('blog/category/{id}/delete'     , 'BlogController@destoryCategory'    );
        Route::get('blog/category/data'             , 'BlogController@getCategoryData'    );
        Route::get('blog/category/create'           , 'BlogController@createCategory'     );
        Route::get('blog/expert'                    , 'BlogController@showExpert'         );
        Route::get('blog/expert/data'               , 'BlogController@getExpert'          );

        Route::get('activity/category'              , 'ActivityController@showCategory'   );
        Route::post('activity/category'             , 'ActivityController@storeCategory'  );
        Route::get('activity/category/{id}'         , 'ActivityController@getCategory'    );
        Route::post('activity/category/{id}/update' , 'ActivityController@updateCategory' );
        Route::get('activity/category/{id}/delete'  , 'ActivityController@deleteCategory' );
        Route::post('activity/category/{id}/delete' , 'ActivityController@destoryCategory');
        Route::get('activity/category/data'         , 'ActivityController@getCategoryData');
        Route::get('activity/category/create'       , 'ActivityController@createCategory' );
        Route::get('activity/hoster'                , 'ActivityController@showExpert'     );
        Route::get('activity/hoster/data'           , 'ActivityController@getExpert'      );


        // no yet
        Route::get('filter/data'            , 'AdminController@showMember'    );
        Route::get('filter/{id}/delete'     , 'AdminController@showMember'    );
        Route::post('filter/{id}/update'    , 'AdminController@showMember'    );
        Route::resource('filter'            , 'AdminController@showMember'    );

        Route::get('ad'                     , 'AdminController@showMember'    );
        Route::get('point'                  , 'AdminController@showMember'    );
        Route::get('coupon'                 , 'AdminController@showMember'    );
        Route::get('invoice'                , 'AdminController@showMember'    );
        Route::get('analysis'               , 'AdminController@showMember'    );

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
