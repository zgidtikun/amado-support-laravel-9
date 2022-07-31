<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetController;

Route::controller(loginController::class)->group(function(){
    Route::prefix('login')->group(function(){
        Route::get('/', 'index')->name('login');
        Route::post('auth', 'authenticate')->name('login-auth');
    });
    
    Route::get('logout', 'logout')->name('logout');
});

// All Auth
Route::middleware(['auth'])->group(function(){    
    Route::controller(HomeController::class)->group(function(){        
        Route::get('/', 'index');
        Route::get('home', 'index')->name('home');
    });   
});

// Admin Auth
Route::middleware(['auth','user-access:admin'])->group(function(){    
    Route::prefix('admin')->group(function(){

        Route::controller(RegisterController::class)->group(function(){
            Route::prefix('register')->group(function(){
                Route::get('/', 'index')->name('register');
                Route::post('create', 'registration')->name('register-create');
            });
        });

        Route::controller(LocationController::class)->group(function(){
            Route::prefix('location')->group(function(){
                Route::get('/', 'index');
                Route::get('all', 'get_all');
                Route::post('setup', 'set_location');
            });
        }); 

        Route::controller(AssetController::class)->group(function(){
            Route::prefix('asset-type')->group(function(){
                Route::get('/', 'index_asset_type');
                Route::get('all', 'get_asstty_all');
                Route::post('setup', 'set_assetty');
            });
        });

    }); 
});


