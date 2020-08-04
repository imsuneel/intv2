<?php

use Illuminate\Support\Facades\Route;
Route::get('/', 'HomeController@welcome');

Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');

Route::get('/get-users', 'UserController@getUsers');
#https://docs.microsoft.com/en-us/graph/api/user-list?view=graph-rest-1.0&tabs=http
