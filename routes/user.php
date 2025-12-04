<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ShopController;

use App\Http\Controllers\User\userProfileController;
use App\Http\Controllers\User\UserDashboardController;

// user
Route::group(['prefix' => 'user', 'middleware' => 'user'], function(){

    Route::get('/home', [UserDashboardController::class, 'index'])->name('userDashboard');

    Route::get('/shop/{category_id?}' , [ShopController::class , 'shop'])->name('shopList');

    Route::get('details/{id}', [ShopController::class, 'details'])->name('shopDetails');

    Route::post('comment', [ShopController::class, 'comment'])->name('comment');

    Route::post('addRating', [ShopController::class, 'addRating'])->name('addRating');

    Route::get('cart', [ShopController::class, 'cart'])->name('cart');

    Route::post('addToCart', [ShopController::class, 'addToCart'])->name('addToCart');

    Route::get('remove/cart', [ShopController::class, 'removeCart'])->name('removeCart');

    Route::get('order', [ShopController::class, 'order'])->name('order');

    Route::get('orderList', [ShopController::class, 'orderList'])->name('orderList');

    Route::get('orderDetails/{userOrderCode}' , [ShopController::class,'orderDetails'])->name('orderDetails');

    Route::get('payment', [ShopController::class, 'payment'])->name('payment');

    Route::post('order/product', [ShopController::class, 'orderProduct'])->name('orderProduct');


    // profile
    Route::prefix('profile')->group(function(){
        Route::get('detail', [userProfileController::class, 'profileDetails'])->name('userprofileDetails');
        Route::post('update', [userProfileController::class, 'update'])->name('userprofileUpdate');
    });

    // password change
    Route::prefix('password')->group(function(){
        Route::get('change', [AuthController::class, 'changePasswordPage'])->name('userpasswordChange');
        Route::post('change', [AuthController::class, 'changePassword'])->name('userChangePassword');
    });

    
});