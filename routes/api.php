<?php

use Illuminate\Http\Request;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::group(['prefix' => 'rest/v0'], function () {

//    Route::resource('user/skills', 'Api\Builder\User\SkillsController');
    Route::resource('exps', 'Api\Common\ExpController');
//    Route::resource('exp/{expId}/skills', 'Api\Builder\Exp\SkillsController');




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

