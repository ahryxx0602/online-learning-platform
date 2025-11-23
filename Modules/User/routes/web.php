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
    Route::prefix('admin')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get("/", "UserController@index")->name("admin.users.index");
            Route::get("/data", "UserController@data")->name("admin.users.data");
            Route:: get("/create", "UserController@create")->name("admin.users.create");
            Route:: post("/create", "UserController@store")->name("admin.users.store");
            Route::get("edit/{user}", "UserController@edit")->name("admin.users.edit");
            Route::post("edit/{user}", "UserController@update")->name("admin.users.update");
        });
    });
});
