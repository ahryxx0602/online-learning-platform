<?php

use Illuminate\Support\Facades\Route;
use Modules\Courses\Http\Controllers\CoursesController;

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

Route::group(['namespace' => 'Modules\Courses\Http\Controllers', 'middleware' => ['web', 'auth']] , function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('courses')->name('courses.')->group(function () {
            Route::get("/", "CoursesController@index")->name('index');
            Route::get("/data", "CoursesController@data")->name('data');
            Route::get("/create", "CoursesController@create")->name('create');
            Route::post("/create", "CoursesController@store")->name('store');
            Route::get("edit/{course}", "CoursesController@edit")->name('edit');
            Route::put("edit/{course}", "CoursesController@update")->name('update');
            Route::delete("delete/{course}", "CoursesController@delete")->name('delete');
            Route::delete("delete-multiple", "CoursesController@deleteMultiple")->name('deleteMultiple');
        });
    });
});
Route::group(['prefix' => 'filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
