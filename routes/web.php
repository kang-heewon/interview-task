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

Route::get('/books', 'BookContoller@index');
Route::get('/books/:id', 'BookContoller@show');
Route::post('/books', 'BookContoller@store');
Route::put('/books/:id', 'BookContoller@update');
Route::delete('/books/:id', 'BookContoller@destroy');
