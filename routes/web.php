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
Route::get('/', 'PagesController@index');


//Route::get('/', function () {
    //return view('welcome');
//});
//routes
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Route::get('/cont', 'PagesController@cont');
//rss
Route::get('feed', 'PostsController@render');

Route::resource('posts','PostsController');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/posts/create', 'PostsController@create')->middleware('administrator'); //only admin can make a post
//streams
Route::get('/streams/create', 'StreamController@create')->middleware('subscriber');
Route::get('/streams/edit', 'StreamController@edit')->middleware('subscriber');
Route::get('/streams/index', 'StreamController@index')->middleware('auth');
Route::get('/streams', 'StreamController@index')->middleware('auth');


//LANG
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);