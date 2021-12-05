<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\PageController as ClientPageController;
use App\Http\Controllers\Client\PostController as ClientPostController;
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
    Route::resource('pages', PageController::class)->except('show');
    Route::resource('posts', PostController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('tags', TagController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('media', MediaController::class)->only(['index', 'store']);
    Route::resource('settings', SettingController::class)->only(['index', 'store']);
    Route::get('profile', [ProfileController::class, 'showProfile'])->name('users.profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('users.update-profile');
    Route::put('profile/update-password', [ProfileController::class, 'updatePassword'])->name('users.update-profile-password');
    Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
});

Route::get('/{slug}', [ClientPageController::class, 'show'])->name('client.pages.show');
