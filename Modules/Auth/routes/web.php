<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Admin\LoginController;


Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login.post');

    // Đăng xuất (cần đăng nhập)
    Route::post('logout', 'logout')->name('logout')->middleware('auth');
});