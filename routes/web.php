<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    // Admin/user
    Route::get('/admin/user/list', [App\Http\Controllers\AdminUserController::class, 'list'])->name('admin.user.list');
    Route::get('/admin/user/add', [App\Http\Controllers\AdminUserController::class, 'add'])->name('admin.user.add');
    Route::post('/admin/user/store', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/edit/{id}', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/admin/user/update/{id}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('admin.user.update');
    Route::get('/admin/user/delete/{id}', [App\Http\Controllers\AdminUserController::class, 'delete'])->name('admin.user.delete');
    Route::get('/admin/user/profile', [App\Http\Controllers\AdminUserController::class, 'profile'])->name('admin.user.profile');
    Route::post('/admin/user/profileUpdate/{id}', [App\Http\Controllers\AdminUserController::class, 'profileUpdate'])->name('admin.user.profileUpdate');

    Route::post('/admin/user/action', [App\Http\Controllers\AdminUserController::class, 'action'])->name('admin.user.action');
});
