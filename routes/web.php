<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/**route home**/
Route::get('/home', 'HomeController@index')->name('home');

/**route search**/
Route::get('/search', 'HomeController@searchbar')->name('searching');

/**1er route detail au clic apres recherche par ex**/

Route::get('/detail/{id}', 'HomeController@detailmovie')->name('detailmovie');
Route::post('/detail/{id}', 'HomeController@detailmovie');

/**route post like**/
Route::post('/detail/{id}/like','PopmovieController@likemovie')->name('like');
//profil routes
Route::get('/profil','ProfilController@index')->name('profil');
Route::post('/profil','ProfilController@editPswd')->name('editPswd');

Route::get('/profil/historic','ProfilController@gethistoric')->name('historic');

Auth::routes();
/**route check if movie is set in popmovie table**/
Route::post('/detail/{id}', 'PopmovieController@index');

//route add commentaire
Route::post('/detail/{id}/addcomm','CommentController@addcom')->name('addcomm');
//route get commentaire
Route::get('/detail/{id}/comm','CommentController@getcomm')->name('getcomm');
//route delete comm
Route::post('/detail/{id}/deletecomm','CommentController@deletecomm')->name('deletecomm');
Route::post('/detail/{id}/delete/{idmovie}','CommentController@deletecomm')->name('deletecomm');

//Route::get('/detail/{id}', 'PopmovieController@index');



