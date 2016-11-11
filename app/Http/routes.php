<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */



Route::get('/', function () {
    
    
    if (Auth::check() || Auth::viaRemember()) {
    
      
        return view('public.home');
    } else {
     
          
        return view('public.home');
    }
});

Route::get('/terms', function () {
    return view('public.terms');
});

Route::group(['middleware' => 'auth'], function () {
    //with csrf-token
    Route::group(['middleware' => 'csrf-token'], function () {
        Route::group(['middleware' => 'billing-info'], function () {
            Route::group(['namespace' => 'User'], function() {

                Route::get('billing-info', 'BillingController@info');
                Route::post('billing-info', 'BillingController@saveInfo');

                // edit billing into
                Route::get('edit-billing-info/{utype?}',
                    'BillingController@getBillingInfo');
                Route::post('edit-payment-profile',
                    'BillingController@editPaymentProfile');
                Route::post('upgrade-agent',
                    'BillingController@upgradeAgentType');

                //home
                Route::get('home', 'HomeController@index');
                Route::post('home', 'HomeController@saveInfo');

                // edit profile
                Route::get('edit-profile', 'HomeController@getProfile');
                Route::post('edit-profile', 'HomeController@postProfile');

                // change profile image
                Route::get('change-image', 'HomeController@getProfileImage');
                Route::get('change-image', 'HomeController@postProfileImage');
                Route::post('change-image', 'HomeController@postProfileImage');
                Route::get('save-image', 'HomeController@saveProfileImage');

                //showings
                Route::get('showings', 'ShowingsController@index');
                Route::post('showings/list', 'ShowingsController@listShowings');
                Route::get('showings/my-showings', 'ShowingsController@myShowings');
                Route::get('showings/add', 'ShowingsController@add');
                Route::post('showings/add', 'ShowingsController@save');
                Route::post('showings/view', 'ShowingsController@view');
                Route::post('showings/accept', 'ShowingsController@accept');
                Route::get('showings/view-your',
                    'ShowingsController@viewYourShowings');
                Route::post('showings/list-users/{type?}',
                    'ShowingsController@listUsersShowings');
                Route::post('showings/feedback-form',
                    'ShowingsController@feedbackForm');
                Route::post('showings/feedback','ShowingsController@feedback');
                Route::get('showings/edit/{id}', 'ShowingsController@edit');
                Route::post('showings/edit/{id}', 'ShowingsController@edit');
                Route::get('showings/delete/{id}', 'ShowingsController@delete');
                Route::get('showings/blockshowings/{id}', 'ShowingsController@showingBlock');
                Route::post('showings/blockPost/', 'ShowingsController@blockPost');
                Route::post('showings/reviewPost/', 'ShowingsController@reviewPost');
                Route::get('showings/showingUser/{id}', 'ShowingsController@showingAgentProfileData');
                Route::post('showings/approve/{id}', 'ShowingsController@showingAgentApprove');
                Route::post('showings/reject/{id}', 'ShowingsController@showingAgentReject');
                Route::post('showings/viewUser', 'ShowingsController@viewShowingDataPopup');
                 Route::post('showings/viewShowingRejected', 'ShowingsController@viewShowingRejectedPopup');

               Route::get('email_template', 'ShowingsController@email_template');
               Route::post('email_template', 'ShowingsController@email_template');
               

            });
        });
    });
});
Route::group(['namespace' => 'Auth'], function() {
    // Authentication routes...
    Route::get('auth/login', array('as' => 'login', 'uses' => 'AuthController@getLogin'));
    Route::get('auth/logout', 'AuthController@getLogout');
    Route::get('auth/register', 'AuthController@getRegister');

    //with csrf-token
    Route::group(['middleware' => 'csrf-token'], function () {
        Route::post('auth/login', 'AuthController@postLogin');
        Route::post('auth/register', 'AuthController@postRegister');
        Route::post('auth/', 'AuthController@postRegister');
    });
    
    // Password reset link request routes...
    Route::get('password/email', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');

    // Password reset routes...
    Route::get('password/reset/{token}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');

    // User activation routes...
    Route::get('register/verify/{activationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'AuthController@confirmAccount'
    ]);
});

