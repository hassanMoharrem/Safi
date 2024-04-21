<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('admin')->name('api.admin.')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::post('/data/users', [\App\Http\Controllers\Admin\UserController::class, 'getAllData'])->name('DataUsers');
        Route::post('/create', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('AddUser');
        Route::post('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('ShowUser');
        Route::post('/update/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('UpdateUser');
        Route::post('/delete/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('DeleteUser');
    });
});
Route::middleware('guest')->name('user.')->group(function () {
    Route::post('/login', [\App\Http\Controllers\User\Auth\AuthController::class, 'login'])->name('login.store');
    Route::post('/register', [\App\Http\Controllers\User\Auth\AuthController::class, 'register'])->name('register.store');
});
Route::middleware('auth:sanctum')->group( function () {

    Route::prefix('station')->controller(\App\Http\Controllers\User\DessertStationController::class)->group(function(){
        Route::get('/all','index');
        Route::post('/create','store');
        Route::post('/update/{id}','update');
        Route::get('/show/{id}','show');
        Route::delete('/delete/{id}','destroy');
    });
    Route::prefix('updatePhase')->controller(\App\Http\Controllers\User\UpdatePhaseController::class)->group(function(){
        Route::get('/all/{id}','index');
        Route::post('/create','store');
        Route::post('/update/{id}','update');
        Route::get('/show/{id}','show');
        Route::delete('/delete/{id}','destroy');
    });



});
