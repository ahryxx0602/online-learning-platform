<?php

use Illuminate\Support\Facades\Route;
use Modules\Lessons\Http\Controllers\LessonsController;

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

Route::middleware('auth')
    ->prefix('admin/lessons')
    ->name('admin.lessons.')
    ->group(function () {
        Route::get('/data', [LessonsController::class, 'data'])->name('data');
        Route::get('/{courseId}', [LessonsController::class, 'index'])
            ->whereNumber('courseId')
            ->name('index');
        Route::get('/create', [LessonsController::class, 'create'])->name('create');
        Route::post('/create', [LessonsController::class, 'store'])->name('store');
        Route::get('/edit/{lesson}', [LessonsController::class, 'edit'])->name('edit');
        Route::put('/edit/{lesson}', [LessonsController::class, 'update'])->name('update');
        Route::delete('/delete/{lesson}', [LessonsController::class, 'delete'])->name('delete');
        Route::delete('/delete-multiple', [LessonsController::class, 'deleteMultiple'])->name('deleteMultiple');
    });
