<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

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
// Auth::routes();
// Route::group([], function () {
//     Route::resource('auth', AuthController::class)->names('auth');
// });


Route::group(['namespace' => 'Modules\Auth\Http\Controllers\Admin'], function () {
    Route::get('login', "LoginController@showLoginForm")->name('login');
    Route::post('login', "LoginController@login")->name('login.post');

    // Đăng xuất
    Route::post('logout', "LoginController@logout")->name('logout')->middleware('auth');
});