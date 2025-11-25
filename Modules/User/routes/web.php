<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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

Route::group(['namespace' => 'Modules\User\Http\Controllers', 'middleware' => 'web'] , function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get("/", "UserController@index")->name('index');
            Route::get("/data", "UserController@data")->name('data');
            Route::get("/create", "UserController@create")->name('create');
            Route::post("/create", "UserController@store")->name('store');
            Route::get("edit/{user}", "UserController@edit")->name('edit');
            Route::put("edit/{user}", "UserController@update")->name('update');
            Route::delete("delete/{user}", "UserController@delete")->name('delete');
            Route::delete("delete-multiple", "UserController@deleteMultiple")->name('deleteMultiple');
        });
    });
});
