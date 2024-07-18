<?php

use App\Http\Controllers\Dashboard\CategeriesController;
use App\Http\Controllers\Dashboard\DashboardContrller;
use App\Http\Controllers\Dashboard\ImportProductsController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\UserProfileController;
use App\Http\Middleware\CheckUserType;
use Illuminate\Support\Facades\Route;

// routes for dashboard controllers that require authentication
Route::group([

    'middleware'=>['auth',  'auth.type:admin,super-admin'], // only users with user type admin can access these routes 
    'prefix' => 'dashboard',  
],function(){

    Route::get('/prfile',[UserProfileController::class, 'edit'])->name('userprofile.edit');
    Route::patch('/prfile',[UserProfileController::class, 'update'])->name('userprofile.update');

        
    Route::get('/',[DashboardContrller::class ,'index'])
        ->middleware('auth')
        ->name('dashboard');

    Route::get('/categories/trash',[CategeriesController::class ,'trash'])
        ->name('categories.trash');

    Route::put('/categories/{category}/restore',[CategeriesController::class ,'restore'])
        ->name('categories.restore');

    Route::delete('/categories/{category}/forcedelete',[CategeriesController::class ,'forcedelete'])
        ->name('categories.forcedelete');
    
    Route::resource('/categories',CategeriesController::class)
        ->middleware('auth');
        
    //------------------------cateogries--------

    Route::get('products/import',[ImportProductsController::class,'create'])->name('products.import');

    Route::post('products/import',[ImportProductsController::class,'store']);

    ////////////////////import porducts--------------------------------

    Route::get('/products/trash',[ProductController::class ,'trash'])
        ->name('products.trash');

    Route::put('/products/{product}/restore',[ProductController::class ,'restore'])
        ->name('products.restore');

    Route::delete('/products/{product}/forcedelete',[ProductController::class ,'forcedelete'])
        ->name('products.forcedelete');

    Route::resource('/products',ProductController::class);


    //------------------products---------------

    Route::resource('/orders',OrderController::class);

    Route::resource('/roles',RoleController::class);

    Route::resource('/users',UserController::class);

});
