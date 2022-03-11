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

Route::group(['prefix' => 'laravel-filemanager', 'middleware'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// verified
Route::middleware('auth')->group(function () {
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
    Route::get('/admin/user/changePass', [App\Http\Controllers\AdminUserController::class, 'changePass'])->name('admin.user.changePass');
    Route::post('/admin/user/changePass/{id}', [App\Http\Controllers\AdminUserController::class, 'changePassUpdate'])->name('admin.user.changePassUpdate');
    Route::post('/admin/user/action', [App\Http\Controllers\AdminUserController::class, 'action'])->name('admin.user.action');

    // Admin/page
    Route::get('/admin/page/list', [App\Http\Controllers\AdminPageController::class, 'list'])->name('admin.page.list');
    Route::get('/admin/page/add', [App\Http\Controllers\AdminPageController::class, 'add'])->name('admin.page.add');
    Route::post('/admin/page/store', [App\Http\Controllers\AdminPageController::class, 'store'])->name('admin.page.store');
    Route::get('/admin/page/edit/{id}', [App\Http\Controllers\AdminPageController::class, 'edit'])->name('admin.page.edit');
    Route::post('/admin/page/update/{id}', [App\Http\Controllers\AdminPageController::class, 'update'])->name('admin.page.update');
    Route::get('/admin/page/delete/{id}', [App\Http\Controllers\AdminPageController::class, 'delete'])->name('admin.page.delete');
    Route::post('/admin/page/action', [App\Http\Controllers\AdminPageController::class, 'action'])->name('admin.page.action');

    // Admin/post/cat
    Route::get('/admin/post/cat/list', [App\Http\Controllers\AdminCategoryPostController::class, 'list'])->name('admin.catPost.list');
    Route::post('/admin/post/cat/add', [App\Http\Controllers\AdminCategoryPostController::class, 'add'])->name('admin.catPost.add');
    Route::get('/admin/post/cat/edit/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'edit'])->name('admin.catPost.edit');
    Route::post('/admin/post/cat/update/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'update'])->name('admin.catPost.update');
    Route::get('/admin/post/cat/delete/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'delete'])->name('admin.catPost.delete');
    Route::post('/admin/post/cat/action', [App\Http\Controllers\AdminCategoryPostController::class, 'action'])->name('admin.catPost.action');
});
