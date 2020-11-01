<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('/pages')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('admin.pages.index');
        Route::get('/create', [PageController::class, 'create'])->name('admin.pages.create');
        Route::get('/edit/{id}', [PageController::class, 'edit'])->name('admin.pages.edit');
        Route::post('/', [PageController::class, 'store'])->name('admin.pages.store');
        Route::put('/{id}', [PageController::class, 'update'])->name('admin.pages.update');
        Route::delete('/{id}', [PageController::class, 'destroy'])->name('admin.pages.delete');
    });

    Route::prefix('/posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('admin.posts.index');
        Route::get('/edit/:id', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::post('/', [PostController::class, 'store'])->name('admin.posts.store');
        Route::put('/:id', [PostController::class, 'update'])->name('admin.posts.update');
        Route::delete('/:id', [PostController::class, 'destroy'])->name('admin.posts.delete');
    });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/edit/:id', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/:id', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/:id', [UserController::class, 'destroy'])->name('admin.users.delete');
    });

    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
});
