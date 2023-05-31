<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers\Auth'], function () {
    Route::post('login', 'LoginController');
    Route::post('signup', 'SignupController');
    Route::get('me', 'MeController');
    Route::post('logout', 'LogOutController');
});

Route::group(['prefix' => 'snippets', 'namespace' => 'App\Http\Controllers\Snippets'], function () {
    Route::get('', 'SnippetController@index');
    Route::post('', 'SnippetController@store');
    Route::get('{snippet}', 'SnippetController@show');
    Route::patch('{snippet}', 'SnippetController@update');
    Route::delete('{snippet}', 'SnippetController@destroy');
    Route::patch('{snippet}/steps/{step}', 'StepController@update');
    Route::delete('{snippet}/steps/{step}', 'StepController@destroy');
    Route::post('{snippet}/steps', 'StepController@store');
});

Route::group(['prefix' => 'me', 'namespace' => 'App\Http\Controllers\Me'], function () {
    Route::get('snippets', 'SnippetController@index');
});

Route::group(['prefix' => 'users/{user}', 'namespace' => 'App\Http\Controllers\Users'], function () {
    Route::get('', 'UserController@show');
    Route::patch('', 'UserController@update');
    Route::get('snippets', 'SnippetController@index');
});

Route::group(['prefix' => 'keys', 'namespace' => 'App\Http\Controllers\Keys'], function () {
    Route::get('algolia', 'AlgoliaKeyController');
});
