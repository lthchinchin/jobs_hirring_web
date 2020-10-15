<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
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

Route::get('/topic','topicController@index');
Route::get('/topic-load','topicController@load');
Route::get('/topic-like/{id_topic}/{id_liker}','topicController@like');
Route::get('/topic-{id}','topicController@detail');
Route::post('/topic-create','topicController@create');
Route::post('/topic-cmt','topicController@comment');
Route::get('/topic-del/{id}/{acc}','topicController@deltopic');
Route::get('/topic-edit/{id}','topicController@edittopic');
Route::get('/loadchat', function () {
    // return view('user.loadchat');
    $chatchit = DB::table('tbl_chat')->get();
    foreach ($chatchit as $c) {
        echo "<h6>$c->content</h6>";
    }
});

Route::get('/chat', function () {
    // $chatchit = DB::table('tbl_chat')->get();
    // dd($chatchit);
    return view('user.chatbox');
});


Route::post('/chatting', function (Request $request) {
    DB::table('tbl_chat')->insert(
        ['content' => $request->mess]
    );
    // return response
    $response = [
        'success' => true,
        'message' => 'insert successfully.',
    ];
    return response()->json($response, 200);
});

Route::get('/change-status/{id}', 'adminController@change_status');
Route::get('/del/{id}', 'adminController@delpost');
Route::get('/multidel/{id}', 'adminController@multidelpost');

Route::get('/', 'datascrapeController@data_display');
Route::get('/dog', 'datascrapeController@randomdog');

Route::get('/login', 'datascrapeController@login');
Route::post('/login', 'accoutController@acc_truePass');
Route::get('/logout', 'accoutController@acc_logout');
Route::get('/diagram', 'chartController@diagramshow');
Route::get('/diagram2', 'chartController@diagramshow2');
Route::get('/diagram-{pl}', 'chartController@diagramshowplus');
Route::get('/diagram2', 'chartController@diagramshow2');
Route::get('/diagram2-{cn}', 'chartController@diagramshowplus2');
Route::resource('/admin-jobhiring', 'adminController');
Route::resource('/admin-account', 'AccountmanageController');

// Route::resource('brandAjax','BrandAjaxController');
