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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/users/account', 'UserController@account')->name('account');
Route::post('/users/updatePW', 'UserController@updatePW')->name('update.pw');
Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/read-user', 'UserController@read')->name('read.user');
Route::post('/users/create-user', 'UserController@store')->name('create.user');
Route::post('/users/update/{id}', 'UserController@update')->name('update.user');
Route::post('/users/delete/{id}', 'UserController@destroy')->name('delete.user');

Route::get('/roles', 'RoleController@index')->name('roles');
Route::get('/roles/read-role', 'RoleController@read')->name('read.role');
Route::post('/roles/create-role', 'RoleController@store')->name('create.role');
Route::post('/roles/update/{id}', 'RoleController@update')->name('update.role');
Route::post('/roles/delete/{id}', 'RoleController@destroy')->name('delete.role');

Route::get('/expensecat', 'ExpenseCatController@index')->name('expensecat');
Route::get('/expensecat/read-expensecat', 'ExpenseCatController@read')->name('read.expensecat');
Route::post('/expensecat/create-expensecat', 'ExpenseCatController@store')->name('create.expensecat');
Route::post('/expensecat/update/{id}', 'ExpenseCatController@update')->name('update.expensecat');
Route::post('/expensecat/delete/{id}', 'ExpenseCatController@destroy')->name('delete.expensecat');

Route::get('/expenses', 'ExpensesController@index')->name('expenses');
Route::get('/expenses/read-user', 'ExpensesController@read')->name('read.expense');
Route::post('/expenses/create-expense', 'ExpensesController@store')->name('create.expense');
Route::post('/expenses/update/{id}', 'ExpensesController@update')->name('update.expense');
Route::post('/expenses/delete/{id}', 'ExpensesController@destroy')->name('delete.expense');