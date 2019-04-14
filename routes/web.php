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

Auth::routes();

Route::any('/', 'HomeController@index')->name('home');
Route::get('/changepassword', 'HomeController@changePasswordView');
Route::post('/changepassword/store', 'HomeController@changePassword');
//Users
Route::get('/users', 'UsersController@index');
Route::post('/users/store', 'UsersController@store');
Route::get('/users/{user}/editpass', 'UsersController@editPass');
Route::post('/users/updatepass/{user} ', 'UsersController@updatePass');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::post('/users/update/{user} ', 'UsersController@update');
Route::post('/users/delete/{user}', 'UsersController@destroy');
// Customers
Route::get('/customers/create ', 'CustomersController@create')->name('create');
Route::get('/customers ', 'CustomersController@index')->name('customers');
Route::post('/customers/store', 'CustomersController@store');
Route::get('/customers/{customer}/edit ', 'CustomersController@edit')->name('editcustomers');
Route::patch('/customers/update/{customer} ', 'CustomersController@update');
Route::delete('/customers/delete/{customer}', 'CustomersController@destroy');
// Accounts
Route::get('/customers/{customer}/accounts ', 'AccountsController@index')->name('accounts');
Route::get('/customers/{customer}/accounts/create ', 'AccountsController@create');
Route::post('/customers/{customer}/accounts/store', 'AccountsController@store');
Route::get('/customers/{customer}/accounts/{account}/edit', 'AccountsController@edit');
Route::post('/customers/{customer}/accounts/{account}', 'AccountsController@update')->name('account.edit');
Route::post('/customers/delete/{customer}/account/{account}', 'AccountsController@destroy')->name('account.destroy');
Route::get('/customers/{customer}/accounts/{account}/serverslist', 'AccountsController@serverslist');
Route::get('/account/{account}/manage-servers', 'AccountsController@manageServers');
Route::post('/account/{account}/update-servers', 'AccountsController@updateServers');
Route::get('/account/{account}/messages/', 'AccountsController@messages');
// Servers
Route::get('/servers ', 'ServersController@index')->name('servers');
Route::get('/servers/create ', 'ServersController@create');
Route::post('/servers/store', 'ServersController@store');
Route::get('/servers/{server}/edit', 'ServersController@edit');
Route::post('/servers/{server}/update', 'ServersController@update')->name('servers.edit');
Route::post('/servers/{server}', 'ServersController@destroy')->name('servers.destroy');
Route::get('/servers/{server}/accounts', 'ServersController@accounts');
Route::get('/servers/{server}/manage-accounts', 'ServersController@manageAccounts');
Route::post('/fetch/{server}', 'ServersController@fetch')->name('serversmanage.fetch');
Route::post('/servers/{server}/update-accounts', 'ServersController@updateAccounts');
