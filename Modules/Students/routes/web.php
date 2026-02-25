<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

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
    ->prefix('admin/students')
    ->name('admin.students.')
    ->group(function () {
        Route::get('/', [StudentsController::class, 'index'])->name('index');
        Route::get('/data', [StudentsController::class, 'data'])->name('data');
        Route::get('/create', [StudentsController::class, 'create'])->name('create');
        Route::post('/create', [StudentsController::class, 'store'])->name('store');
        Route::get('/edit/{student}', [StudentsController::class, 'edit'])->name('edit');
        Route::put('/edit/{student}', [StudentsController::class, 'update'])->name('update');
        Route::delete('/delete/{student}', [StudentsController::class, 'delete'])->name('delete');
        Route::delete('/delete-multiple', [StudentsController::class, 'deleteMultiple'])->name('deleteMultiple');
    });
