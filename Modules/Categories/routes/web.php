<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoriesController;

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

Route::group(['namespace' => 'Modules\Categories\Http\Controllers', 'middleware' => ['web', 'auth']] , function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get("/", "CategoriesController@index")->name('index');
            Route::get("/data", "CategoriesController@data")->name('data');
            Route::get("/create", "CategoriesController@create")->name('create');
            Route::post("/create", "CategoriesController@store")->name('store');
            Route::get("edit/{category}", "CategoriesController@edit")->name('edit');
            Route::put("edit/{category}", "CategoriesController@update")->name('update');
            Route::delete("delete/{category}", "CategoriesController@delete")->name('delete');
            Route::delete("delete-multiple", "CategoriesController@deleteMultiple")->name('deleteMultiple');
        });
    });
});


