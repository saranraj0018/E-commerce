<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\Admin\Home;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TempImagesController;
use Illuminate\Http\Request;

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

        Route::view('/login',  'admin.login')->name('admin.login');
        Route::post('/authenticate', [AdminLogin::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware'=> 'admin.auth'],function (){
        Route::get('/dashboard', [Home::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [Home::class, 'logout'])->name('admin.logout');

        // category Route
        Route::get('/category/list', [CategoryController::class, 'list'])->name('category.list');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/save', [CategoryController::class, 'save'])->name('category.save');

        // temp-image.create
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        Route::get('/getSlug',function (Request $request) {
            $slug = '';
            if (!empty($request->title)) {
             $slug = \Illuminate\Support\Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');


    });
});
