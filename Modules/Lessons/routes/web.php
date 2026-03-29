<?php

use Illuminate\Support\Facades\Route;
use Modules\Lessons\Http\Controllers\LessonsController;
use Modules\Lessons\app\Http\Controllers\Clients\LessonsController as ClientsLessonsController;

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
        Route::get('/{courseId}', [LessonsController::class, 'index'])->name('index');
        Route::get('/{courseId}/create', [LessonsController::class, 'create'])->name('create');
        Route::get('/{courseId}/data', [LessonsController::class, 'data'])->name('data');
        Route::post('/{courseId}/create', [LessonsController::class, 'store'])->name('store');
        Route::get('/edit/{lessonId}', [LessonsController::class, 'edit'])->name('edit');
        Route::put('/edit/{lessonId}', [LessonsController::class, 'update'])->name('update');
        Route::delete('/delete/{lessonId}', [LessonsController::class, 'delete'])->name('delete');
        Route::get('/{courseId}/sort', [LessonsController::class, 'sort'])->name('sort');
        Route::post('/{courseId}/sort', [LessonsController::class, 'handleSort'])->name('handleSort');
        Route::delete('/delete-multiple', [LessonsController::class, 'deleteMultiple'])->name('deleteMultiple');
    });

Route::group(['as' => 'lessons.'], function () {
    Route::get('bai-hoc/{slug}', [ClientsLessonsController::class, 'detail'])->name('detail');
});

