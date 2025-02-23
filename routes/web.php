<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [EventController::class, 'index']);

Route::get('/events', [EventController::class, 'index']);

Route::get('/events/detail/{id}', [EventController::class, 'detail']);

Route::get('/events/add', [EventController::class, 'add'])->middleware('auth');

Route::post('/events/add', [EventController::class, 'create']);

Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');

Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth');

Route::delete('/events/delete/{id}', [EventController::class, 'delete'])->middleware('auth');

Route::post('/comments/add', [CommentController::class, 'create']);

Route::get('/comments/delete/{id}', [CommentController::class, 'delete']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::put('/admin/ban/{user}', [AdminController::class, 'ban'])->name('admin.ban');

Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');

Route::delete('/admin/delete/{user}', [AdminController::class, 'delete'])->name('admin.delete');
