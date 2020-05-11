<?php

use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
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

Route::get('/users/page', [UserController::class, 'page'])->name('users_page');
Route::get('/users/all', [UserController::class, 'all'])->name('users_all');

Route::get('/sections/page', [SectionController::class, 'page'])->name('sections_page');

Route::resource('users', 'UserController')->middleware('json_parse');

Route::resource('sections', 'SectionController')->middleware('json_parse');

