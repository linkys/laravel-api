<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('clients', 'ClientsController@getClients');
//Route::get('clients/{id}', 'ClientsController@getClient');
//Route::post('clients', 'ClientsController@removeClient');
//Route::delete('clients/{id}', 'ClientsController@removeClient');

Route::resource('clients', 'ClientsController');
Route::resource('projects', 'ProjectsController');