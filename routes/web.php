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
Route::group(['middleware' => 'tenancy.enforce'], function () {
    Auth::routes();
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/create/website', 'TenantController@createWebsite');

Route::get('/add/hostname', 'TenantController@addHostname');

Route::get('/get/tenant', 'TenantController@getTenant');

Route::get('/create/tenant/user', 'TenantController@createUser');

Route::get('/create/full/tenant', 'TenantController@fullTenantCreate');
