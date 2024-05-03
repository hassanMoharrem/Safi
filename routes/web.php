<?php

use Illuminate\Support\Facades\Route;
Route::post('locale',[\App\Http\Controllers\LanguageController::class,'switch'])->name('language.switch');

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'loginIndex'])->name('login.index');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'login'])->name('login.store');
});
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',[\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users',[\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/logout', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'logout'])->name('logout');
});

                                        ///   User   ///
Route::middleware('guest')->name('user.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\User\Auth\AuthController::class, 'loginIndex'])->name('login.index');
    Route::post('/login', [\App\Http\Controllers\User\Auth\AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [\App\Http\Controllers\User\Auth\AuthController::class, 'registerIndex'])->name('register.index');
    Route::post('/register', [\App\Http\Controllers\User\Auth\AuthController::class, 'register'])->name('register.store');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[\App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/profile',[\App\Http\Controllers\User\ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile/{id}',[\App\Http\Controllers\User\ProfileController::class, 'show'])->name('user.profile.show');
    Route::post('/profile',[\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/update',[\App\Http\Controllers\User\ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/logout', [\App\Http\Controllers\User\Auth\AuthController::class, 'logout'])->name('logout');
});
