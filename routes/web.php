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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/archive', 'HomeController@archive')->name('archive');
Route::get('/filter', 'HomeController@filter')->name('filter');
Route::post('/add-worker', 'HomeController@add_worker')->name('add_worker');
Route::post('/add-number', 'HomeController@add_number')->name('add_number');
Route::get('/success-user', 'HomeController@success_user')->name('success_user');
Route::get('/edit-user', 'HomeController@edit_user')->name('edit_user');
Route::get('/edit-number', 'HomeController@edit_number')->name('edit_number');
Route::get('/delete-user', 'HomeController@delete_user')->name('delete_user');
Route::get('/send-message-user', 'HomeController@send_message')->name('send_message');
Route::get('/smstoken', 'HomeController@smstoken')->name('smstoken');
Route::get('/commentrelays', 'HomeController@commentsrelay')->name('commentrelays');
Route::get('/numbers', 'HomeController@numbers')->name('numbers');
Route::get('/departments', 'HomeController@departments')->name('departments');
Route::post('/add-department', 'HomeController@add_department')->name('add_department');
Route::post('/edit-department', 'HomeController@edit_department')->name('edit_department');
Route::get('/delete-department', 'HomeController@delete_department')->name('delete_department');
Route::get('/organizations', 'HomeController@organizations')->name('organizations');
Route::post('/add-organization', 'HomeController@add_organization')->name('add_organization');
Route::post('/edit-organization', 'HomeController@edit_organization')->name('edit_organization');
Route::get('/delete-organization', 'HomeController@delete_organization')->name('delete_organization');
Route::get('/delete-number', 'HomeController@deletenumber')->name('delete_number');



