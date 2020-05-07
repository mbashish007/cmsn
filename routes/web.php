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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('users', 'UserController')->middleware('auth');
Route::resource('repos', 'RepoController')->middleware('auth');
Route::resource('posts', 'PostController')->middleware('auth');

Route::post('/repos/like','RepoController@likeRepo')->middleware('auth')->name('likeRepo');
Route::post('/posts/like','PostController@likePost')->middleware('auth')->name('likePost');
Route::post('/posts/{post}/comment','PostController@createComment')->middleware('auth')->name('createComment');
Route::resource('tags','TagController')->middleware('auth');

Route::get('repos/{repo}/add_file','RepoController@addFile')->middleware('auth')->name('repos.add_file');
Route::resource('files','FileController');