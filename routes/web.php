<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Client\PageController as ClientPageController;
use App\Http\Controllers\Client\PostController as ClientPostController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\Client\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\Client\HomeController::class, 'index'])->name('home');
Route::get('/contact', [App\Http\Controllers\Client\HomeController::class, 'contact'])->name('contact');
Route::get('/about', [App\Http\Controllers\Client\HomeController::class, 'about'])->name('about');

Route::prefix('/posts')->group(function () {
    Route::get('/', [ClientPostController::class, 'index'])->name('client.posts.index');
    Route::get('/{slug}', [ClientPostController::class, 'show'])->name('client.posts.show');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/pages')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('pages.index');
        Route::get('/create', [PageController::class, 'create'])->name('pages.create');
        Route::get('/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
        Route::post('/', [PageController::class, 'store'])->name('pages.store');
        Route::put('/{id}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/{id}', [PageController::class, 'destroy'])->name('pages.delete');
    });

    Route::prefix('/posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.delete');
    });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.delete');
    });

    Route::put('/users/{id}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
});

Route::get('/{slug}', [ClientPageController::class, 'show'])->name('client.pages.show');
