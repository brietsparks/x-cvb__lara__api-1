<?php

use Illuminate\Http\Request;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::group(['prefix' => 'rest'], function () {

    Route::group(['prefix' => 'v0'], function () {

        Route::group(['prefix' => 'builder'], function () {
            Route::resource('exps',                 'Api\Builder\ExpsController');
            Route::resource('skills',               'Api\Builder\ExpsController');

            Route::resource('users/{user_id}/exps',     'Api\Builder\User\ExpsController');
            Route::resource('users/{user_id}/skills',   'Api\Builder\User\SkillsController');

            Route::resource('exps/{exp_id}/skills',     'Api\Builder\Exp\SkillsController');
        });



////    Route::resource('skills', 'Api\Builder\SkillsController');
//    Route::resource('user/skills', 'Api\Builder\User\SkillsController');
//    Route::resource('exps', 'Api\Builder\ExpController');
//    Route::resource('exp/{expId}/skills', 'Api\Builder\Exp\SkillsController');
//
//    Route::group(['prefix' => 'auth'], function () {
//        Route::post('register', 'Api\Common\Auth\RegisterController@register');
//        Route::post('login', 'Api\Common\Auth\AuthController@login');
//        Route::post('authenticate', 'Api\Common\Auth\AuthController@authenticate');
//    });
    });

});

