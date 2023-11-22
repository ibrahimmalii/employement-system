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
    return view('auth.login');
})->name('welcome')->middleware('guest');
Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('users/search', [UserController::class, 'search'])
        ->name('users.search');

    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'search', 'destroy']);

    Route::get('departments/search', [DepartmentController::class, 'search'])
        ->name('departments.search');

    Route::resource('departments', DepartmentController::class)
        ->only('index', 'create', 'store', 'edit', 'update', 'destroy');

    Route::resource('tasks', TaskController::class);
});


