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
Route::get('/create', 'RecipeController@create');
Route::get('/recipes', 'RecipeController@index');
Route::get('/recipe/{id}', 'RecipeController@show');
Route::post('/saverecipe', 'RecipeController@store');
