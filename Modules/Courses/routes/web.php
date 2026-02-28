<?php

use Illuminate\Support\Facades\Route;
use Modules\Courses\app\Http\Controllers\Clients\CoursesController as ClientsCoursesController;
use Modules\Courses\Http\Controllers\CoursesController;

Route::middleware('auth')
    ->prefix('admin/courses')
    ->name('admin.courses.')
    ->group(function () {
        Route::get('/', [CoursesController::class, 'index'])->name('index');
        Route::get('/data', [CoursesController::class, 'data'])->name('data');
        Route::get('/create', [CoursesController::class, 'create'])->name('create');
        Route::post('/create', [CoursesController::class, 'store'])->name('store');
        Route::get('/edit/{course}', [CoursesController::class, 'edit'])->name('edit');
        Route::put('/edit/{course}', [CoursesController::class, 'update'])->name('update');
        Route::delete('/delete/{course}', [CoursesController::class, 'delete'])->name('delete');
        Route::delete('/delete-multiple', [CoursesController::class, 'deleteMultiple'])->name('deleteMultiple');
    });

// File manager, chỉ cần web (đã có sẵn từ RouteServiceProvider)
Route::prefix('filemanager')->group(function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['as' => 'courses.'], function(){
    Route::get('/khoa-hoc', [ClientsCoursesController::class, 'index'])->name('index');
    Route::get('/khoa-hoc/{slug}', [ClientsCoursesController::class, 'detail'])->name('detail');
    Route::prefix('data')->name('data.')->group(function() {
        Route::get('/trial/{lessonId?}', [ClientsCoursesController::class, 'getTrialVideo'])->name('trial');
    }); 
});