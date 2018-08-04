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

//首頁
Route::get('/', 'RegisterController@indexPage');

//掛號
Route::get('/deptselect',       'RegisterController@deptDaySelectProcess');
Route::post('/ajax',            'RegisterController@registerProcess');

//查詢
Route::get('/inquire',          'InquireController@patientDataInputPage');
Route::get('/list',             'InquireController@dataListProcess');
Route::get('/validation',       'InquireController@patientDataValidator');
