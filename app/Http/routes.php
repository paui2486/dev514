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
    Route::get('HostGuide'      , 'PageController@HostGuide'    );
    Route::get('PlayGuide'      , 'PageController@PlayGuide'    );
    Route::get('Cooperation'    , 'PageController@Cooperation'  );
    Route::get('MediaReport'    , 'PageController@media-report' );
    Route::get('Partner'        , 'PageController@partner'      );
/*
|--------------------------------------------------------------------------
| Dynamic Routes
|--------------------------------------------------------------------------
*/
    Route::auth();
    Route::get('register/verify/{confirm}'  , 'MainController@confirm'           );

    Route::get('activity'                   , 'ActivityController@showResult'    );
    Route::post('activity'                   , 'ActivityController@showResult'    );
    Route::post('activity/data'             , 'ActivityController@showResult'    );
    Route::get('activity/{id}'              , 'ActivityController@index'         );
    // Route::get('activity/{category}'        , 'ActivityController@showCategory'  );
    // Route::get('activity/{category}/{slug}' , 'ActivityController@showActivity'  );
    // Route::get('purchase'                   , 'ActivityController@purchase'      );
    // Route::get('purchase/confirm'           , 'ActivityController@confirm'       );

    Route::get('blog'                       , 'ArticleController@index'          );
    Route::get('blog/{category}'            , 'ArticleController@showCategory'   );
    Route::get('blog/{category}/{slug}'     , 'ArticleController@showArticle'    );

    Route::get('redirect'                   , 'SocialAuthController@redirect'    );
    Route::get('callback'                   , 'SocialAuthController@fbCallback'    );
    Route::get('follows'                    , 'AuthController@follows'           );
    Route::get('friends'                    , 'AuthController@friends'           );
    Route::get('activitys'                  , 'AuthController@activitys'         );

    Route::group(['middleware' => 'auth'], function() {
        Route::post('purchase/result'           , 'PurchaseController@postByPay2Go'  );
        Route::get('purchase/{activity_id}'     , 'PurchaseController@showPurchase'  );
        Route::post('purchase/{activity_id}'    , 'PurchaseController@postPurchase'  );
        Route::get('purchase/trade/{OrderNo}'   , 'PurchaseController@getTradeInfo'  );
        // Route::get('purchase/{category}/{slug}' , 'PurchaseController@showPurchase'  );
        // Route::post('purchase/{category}/{slug}', 'PurchaseController@postPurchase'  );

        Route::get('dashboard'                        , 'Admin\AdminController@index'           );
        Route::get('dashboard/member'                 , 'Admin\MemberController@index'          );
        Route::get('dashboard/member/profile'         , 'Admin\MemberController@profile'        );
        Route::post('dashboard/member/{id}/update'    , 'Admin\MemberController@update'         );
        Route::get('dashboard/activity/register'      , 'Admin\ActivityController@askExpert'    );
        Route::get('dashboard/activity'               , 'Admin\ActivityController@index'        );
        Route::post('dashboard/activity/register'     , 'Admin\ActivityController@regExpert'    );
        Route::get('dashboard/activity/tickets'       , 'Admin\ActivityController@showTicket'   );
        Route::get('dashboard/activity/tickets/data'  , 'Admin\ActivityController@getTicket'    );
    });

    // for admin
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {
        Route::get('admin'                          , 'AdminController@index');

        Route::get('member/data'                    , 'MemberController@data'             );
        Route::get('member/list'                    , 'MemberController@showMember'       );
        Route::get('member/create'                  , 'MemberController@create'           );
        Route::get('member/{id}'                    , 'MemberController@show'             );
        Route::get('member/{id}/delete'             , 'MemberController@getDelete'        );
        Route::post('member'                        , 'MemberController@store'            );
        Route::delete('member/{id}'                 , 'MemberController@destroy'          );

        // TODO: filter setting, banner setting, event setting.... at system
        Route::get('system'                         , 'SystemController@index'            );
        Route::get('system/{target}'                , 'SystemController@listTarget'       );
        // Route::get('system/filter'                  , 'SystemController@listFilter'       );

        Route::get('banner/data'                    , 'BannerController@data'             );
        Route::get('banner/{id}/delete'             , 'BannerController@getDelete'        );
        Route::post('banner/{id}/update'            , 'BannerController@update'           );
        Route::resource('banner'                    , 'BannerController'                  );

        Route::get('filter/data'                    , 'FilterController@data'    );
        Route::get('filter/{id}/delete'             , 'FilterController@getDelete'    );
        Route::post('filter/{id}/update'            , 'FilterController@update'    );
        Route::resource('filter'                    , 'FilterController'               );
        // Route::get('blog/category'                  , 'BlogController@showCategory'       );
        // Route::post('blog/category'                 , 'BlogController@storeCategory'      );
        // Route::get('blog/category/{id}'             , 'BlogController@getCategory'        );
        // Route::post('blog/category/{id}/update'     , 'BlogController@updateCategory'     );
        // Route::get('blog/category/{id}/delete'      , 'BlogController@deleteCategory'     );
        // Route::post('blog/category/{id}/delete'     , 'BlogController@destoryCategory'    );
        // Route::get('blog/category/data'             , 'BlogController@getCategoryData'    );
        // Route::get('blog/category/create'           , 'BlogController@createCategory'     );
        // Route::get('blog/expert'                    , 'BlogController@showExpert'         );
        // Route::get('blog/expert/data'               , 'BlogController@getExpert'          );

        Route::get('activity/{id}/priview'          , 'ActivityController@showPriview'    );

        Route::get('activity/check'                 , 'ActivityController@showCheckAct'   );
        Route::get('activity/check/data'            , 'ActivityController@getCheckAct'    );

        Route::get('activity/pass/{id}'             , 'ActivityController@passActivity'   );
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
        Route::get('ad'                     , 'AdminController@showMember'    );
        Route::get('point'                  , 'AdminController@showMember'    );
        Route::get('coupon'                 , 'AdminController@showMember'    );
        Route::get('invoice'                , 'AdminController@showMember'    );
        Route::get('analysis'               , 'AdminController@showMember'    );
        Route::get('customer'               , 'CustomerController@customer'   );
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

    // for author
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'author'], function() {
        Route::get('blog/data'                  , 'BlogController@data'           );
        Route::get('blog/{id}/delete'           , 'BlogController@getDelete'      );
        Route::post('blog/{id}/update'          , 'BlogController@update'         );
        Route::resource('blog'                  , 'BlogController'                );
    });

    // for host
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'host'], function() {
        Route::post('activity'                              , 'ActivityController@store'        );
        Route::get('activity/data'                          , 'ActivityController@data'         );
        Route::get('activity/list'                          , 'ActivityController@showActivity' );
        Route::get('activity/checkout'                      , 'ActivityController@showCheckout' );
        Route::post('activity/checkout'                      , 'ActivityController@letCheckout' );
        Route::get('activity/create'                        , 'ActivityController@create'       );
        Route::get('activity/{id}'                          , 'ActivityController@show'         );
        Route::delete('activity/{id}'                       , 'ActivityController@destroy'      );
        Route::get('activity/{id}/delete'                   , 'ActivityController@getDelete'    );
        Route::post('activity/{id}/update'                  , 'ActivityController@update'       );
        // Route::get('activity/history'                       , 'ActivityController@getHistory' );
        // Route::get('activity/old_data'                      , 'ActivityController@showOldData');

        Route::get('activity/{id}/tickets/data'             , 'TicketController@data'         );
        Route::post('activity/{id}/tickets/{tickets}/update', 'TicketController@update'       );
        Route::get('activity/{id}/tickets/{tickets}/delete' , 'TicketController@getDelete'    );
        Route::resource('activity/{id}/tickets'             , 'TicketController'              );
    });
});

/*
 * issue
 *    read more: 1.new blogs. 2. activities by category. 3. IM chat
 */
