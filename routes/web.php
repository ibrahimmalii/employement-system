<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'search', 'destroy']);

    Route::get('departments/search', [DepartmentController::class, 'search'])
        ->name('departments.search');

    Route::resource('departments', DepartmentController::class)
        ->only('index', 'create', 'store', 'edit', 'update', 'destroy');

    Route::resource('tasks', TaskController::class);
});


