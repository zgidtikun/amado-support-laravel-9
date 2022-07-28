<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\HomeController;


Route::get('/', function(){ return view('welcome'); });

Route::controller(RegisterController::class)->group(function(){
    Route::prefix('register')->group(function(){
        Route::get('/', 'index')->name('register');
        Route::post('create', 'registration')->name('register-create');
    });
});

Route::controller(loginController::class)->group(function(){
    Route::prefix('login')->group(function(){
        Route::get('/', 'index')->name('login');
        Route::post('auth', 'authenticate')->name('login-auth');
    });
    
    Route::post('logout', 'logout')->name('logout');
});


Route::controller(HomeController::class)->group(function(){
    Route::get('/home', 'index')->name('home');
});
