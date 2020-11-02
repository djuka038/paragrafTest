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

Route::get('/', function () {
    return view('home');
});

Route::get('update/{id}', 'DocumentController@update');

Route::get('documents', 'DocumentController@getDocuments');
Route::get('document/{id}', 'DocumentController@getDocumentById');
Route::post('document', 'DocumentController@uploadDocument');
Route::post('document/{id}', 'DocumentController@updateDocument');
Route::delete('document/{id}', 'DocumentController@deleteDocument');
Route::get('download/{fileName}', 'DocumentController@downloadDocument');
