<?php

use Illuminate\Support\Facades\Route;
use Modules\Teachers\Http\Controllers\TeachersController;

Route::middleware('auth')
    ->prefix('admin/teachers')
    ->name('admin.teachers.')
    ->group(function () {
        Route::get('/', [TeachersController::class, 'index'])->name('index');
        Route::get('/data', [TeachersController::class, 'data'])->name('data');
        Route::get('/create', [TeachersController::class, 'create'])->name('create');
        Route::post('/create', [TeachersController::class, 'store'])->name('store');
        Route::get('/edit/{teacher}', [TeachersController::class, 'edit'])->name('edit');
        Route::put('/edit/{teacher}', [TeachersController::class, 'update'])->name('update');
        Route::delete('/delete/{teacher}', [TeachersController::class, 'delete'])->name('delete');
        Route::delete('/delete-multiple', [TeachersController::class, 'deleteMultiple'])->name('deleteMultiple');
    });