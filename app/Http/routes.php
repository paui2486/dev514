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

    Route::get('members/{username}'         , 'UserController@index'                    );

    Route::get('activity'                   , 'ActivityController@index'                );
    Route::get('activity/{category}/{slug}' , 'ActivityController@index'                );

    Route::get('blog'                       , 'BlogController@index'                    );
    Route::get('blog/{category}'            , 'BlogController@index'                    );
    Route::get('blog/{category}/{slug}'     , 'BlogController@index'                    );

    Route::get('order/{id}'                 , 'CartController@index'                    );

    Route::get('master'                     , 'UserController@index'                    );

    Route::get('redirect'                   , 'SocialAuthController@redirect'           );
    Route::get('callback'                   , 'SocialAuthController@callback'           );

    Route::get('profile'                    , 'AuthController@profile'                  );
    // Route::get('profile/edit');

    Route::get('follows'                    , 'AuthController@follows'                  );
    Route::get('friends'                    , 'AuthController@friends'                  );
    Route::get('activitys'                  , 'AuthController@activitys'                );

    Route::group(['prefix' => 'dashboard'], function() {

        Route::get('/'                      , 'AdminController@dashboard'               );
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
