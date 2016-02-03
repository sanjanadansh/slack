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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/v1/brit_to_us', 'BritToUSController@britToUs');

Route::post('/api/v1/us_to_brit', 'BritToUSController@usToBrit');

Route::post('/api/v1/internal_docs', 'GithubDocsSearchController@search');

Route::post('/api/v1/jira', 'JiraController@webhook');