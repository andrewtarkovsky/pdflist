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
    return view('index');
});

Route::get('/pdf', 'PdfController@index');
Route::get('/image', 'PdfController@image');
Route::get('/info', 'UtilController@info');

Route::get('/list', 'PdfController@getList');
Route::get('/get-list', 'PdfController@getList');

Route::get('/existing', 'PdfController@parseExisting');
Route::post('/upload', 'PdfController@uploadPdf');