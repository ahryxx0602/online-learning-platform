<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoriesController;

Route::middleware('auth')
    ->prefix('admin/categories')
    ->name('admin.categories.')
    ->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/data', [CategoriesController::class, 'data'])->name('data');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/create', [CategoriesController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/edit/{category}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/delete/{category}', [CategoriesController::class, 'delete'])->name('delete');
        Route::delete('/delete-multiple', [CategoriesController::class, 'deleteMultiple'])->name('deleteMultiple');
    });