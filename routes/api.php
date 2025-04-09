<?php

use App\Http\Controllers\Api\V1\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth',[App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('login');


Route::middleware(['auth:sanctum'])->group(function () {
    //Login Auth
        Route::get('/index',[App\Http\Controllers\Api\V1\LoginController::class, 'index'])->name('index');
    //CRUD Login
        Route::get('/show/{id}',[App\Http\Controllers\Api\V1\LoginController::class, 'show'])->name('show');
        Route::post('/store',[App\Http\Controllers\Api\V1\LoginController::class, 'store'])->name('store');
        Route::put('/update/{id}',[App\Http\Controllers\Api\V1\LoginController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}',[App\Http\Controllers\Api\V1\LoginController::class, 'destroy'])->name('destroy');
    //Search by Name
        Route::get('/search',[App\Http\Controllers\Api\V1\StudentController::class, 'search'])->name('search');
    });



