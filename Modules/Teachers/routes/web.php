<?php

use Illuminate\Support\Facades\Route;
use Modules\Teachers\Http\Controllers\TeachersController;

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

Route::group(['namespace' => 'Modules\Teachers\Http\Controllers', 'middleware' => ['web', 'auth']] , function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('teachers')->name('teachers.')->group(function () {
            Route::get("/", "TeachersController@index")->name('index');
            Route::get("/data", "TeachersController@data")->name('data');
            Route::get("/create", "TeachersController@create")->name('create');
            Route::post("/create", "TeachersController@store")->name('store');
            Route::get("edit/{teacher}", "TeachersController@edit")->name('edit');
            Route::put("edit/{teacher}", "TeachersController@update")->name('update');
            Route::delete("delete/{teacher}", "TeachersController@delete")->name('delete');
            Route::delete("delete-multiple", "TeachersController@deleteMultiple")->name('deleteMultiple');
        });
    });
});
