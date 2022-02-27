<?php


Route::get('/', function () {
    return view('welcome');
});

Route::resource('customers', 'CustomersController')->except('show')->middleware('auth');
Route::resource('orders', 'OrdersController')->except('show')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/orders/archived', 'OrdersController@archived')->name('orders.archived')->middleware('auth');
Route::get('/orders/{id}/restore', 'OrdersController@restore')->name('orders.restore')->middleware('auth');

Route::get('/customers/archived', 'CustomersController@archived')->name('customers.archived')->middleware('auth');
Route::get('/customers/{id}/restore', 'CustomersController@restore')->name('customers.restore')->middleware('auth');

Auth::routes();
