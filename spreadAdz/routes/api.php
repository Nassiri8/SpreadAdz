<?php

use Illuminate\Http\Request;

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

//Log and logout
Route::post('/user', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::get('/users', 'UserController@getUsers');


Route::group([
    'middleware' => 'auth:api'
 ], function()
{
    //Routes Annonces
    Route::get('/annonces', 'AnnoncesController@getAnnonces');
    Route::get('/annonce/{id}', 'AnnoncesController@annonceById');
    Route::get('/annonce/user/{id}', 'AnnoncesController@annonceByUserId');
    Route::post('/annonce/create', 'AnnoncesController@postAnnonce');
    Route::delete('/annonce/delete/{id}', 'AnnoncesController@deleteAnnonce');
    Route::put('/update/{id}', 'AnnoncesController@updateAnnonce');
});

