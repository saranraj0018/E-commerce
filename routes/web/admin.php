<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\Admin\Home;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::group(['prefix'=> 'admin'],function (){

    Route::group(['middleware'=> 'admin.guest'],function (){

        Route::view('/login',  'index')->name('admin.login');
        Route::post('/authenticate', [AdminLogin::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware'=> 'admin.auth'],function (){
        Route::get('/dashboard', [Home::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [Home::class, 'logout'])->name('admin.logout');
    });
});
