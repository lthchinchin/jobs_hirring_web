<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome2', function () {
    return view('welcome2');
});
Route::get('/change-status/{id}', 'adminController@change_status');
Route::get('/del/{id}', 'adminController@delpost');
Route::get('/multidel/{id}', 'adminController@multidelpost');

Route::get('/','datascrapeController@data_display');
Route::get('/dog','datascrapeController@randomdog');

Route::get('/login','datascrapeController@login');
Route::post('/login','accoutController@acc_truePass');
Route::get('/logout','accoutController@acc_logout');
Route::get('/diagram','chartController@diagramshow');
Route::get('/diagram-{pl}','chartController@diagramshowplus');
Route::resource('/admin-jobhirring','adminController');

// Route::resource('brandAjax','BrandAjaxController');

