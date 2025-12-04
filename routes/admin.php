<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderBoardController;
use App\Http\Controllers\Admin\RoleChangeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SaleInformationController;

// admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'] ], function(){

    Route::get('/home', [AdminDashboardController::class, 'index'])->name('adminDashboard');

    // category
    Route::prefix('category')->group(function(){
        Route::get('list', [CategoryController::class, 'list'])->name('categoryList');
        Route::get('create', [CategoryController::class, 'createpage'])->name('categoryCreatePage');
        Route::post('create', [CategoryController::class, 'create'])->name('categoryCreate');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('categoryDelete');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('categoryEdit');
        Route::post('update', [CategoryController::class, 'update'])->name('categoryUpdate');
    });

    // product
    Route::prefix('product')->group(function(){
        Route::get('list', [ProductController::class, 'list'])->name('productList');
        Route::get('create', [ProductController::class, 'create'])->name('productCreatePage');
        Route::post('create', [ProductController::class, 'productCreate'])->name('productCreate');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('productDelete');
        Route::get('details/{id}', [ProductController::class, 'details'])->name('productDetails');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('productEdit');
        Route::post('update', [ProductController::class, 'update'])->name('productUpdate');
    });

    // password change
    Route::prefix('password')->group(function(){
        Route::get('change', [AuthController::class, 'changePasswordPage'])->name('passwordChange');
        Route::post('change', [AuthController::class, 'changePassword'])->name('changePassword');
    });

    // payment
    // Route::prefix('payment')->group(function(){
    //     Route::get('create', [PaymentController::class, 'create'])->name('productCreatePage');
    //     Route::post('create', [PaymentController::class, 'createPayment'])->name('createPayment');
    //     Route::get('delete/{id}', [PaymentController::class, 'delete'])->name('paymentDelete');
    //     Route::get('edit/{id}', [PaymentController::class, 'edit'])->name('paymentEdit');
    //     Route::post('update', [PaymentController::class, 'update'])->name('paymentUpdate');
    // });

    // profile
    Route::prefix('profile')->group(function(){
        Route::get('detail', [ProfileController::class, 'profileDetails'])->name('profileDetails');
        Route::post('update', [ProfileController::class, 'update'])->name('profileUpdate');

        Route::get('create/adminAccount', [ProfileController::class, 'createAdminAccount'])->name('createAdminAccount');
        Route::post('create/adminAccount', [ProfileController::class, 'create'])->name('createAdmin');
        Route::get('account/{id}', [ProfileController::class, 'accountProfile'])->name('accountProfile');
    });

    // admin list
    Route::prefix('role')->group(function(){
        Route::get('adminList', [RoleChangeController::class, 'adminList'])->name('adminList');
        Route::get('deleteAdminAccount/{id}', [RoleChangeController::class, 'deleteAdminAccount'])->name('deleteAdminAccount');
    
        Route::get('userList', [RoleChangeController::class, 'userList'])->name('userList');
        Route::get('deleteUserAccount/{id}', [RoleChangeController::class, 'deleteUserAccount'])->name('deleteUserAccount');
        Route::get('changeAdminRole/{id}', [RoleChangeController::class, 'changeAdminRole'])->name('changeAdminRole');
        Route::get('changeUserRole/{id}', [RoleChangeController::class, 'changeUserRole'])->name('changeUserRole');
    });

    // order board
    Route::prefix('order')->group(function(){
        Route::get('list', [OrderBoardController::class, 'userOrderList'])->name('userOrderList');
        Route::get('details/{orderCode}', [OrderBoardController::class, 'userOrderDetails'])->name('userOrderDetails');
        Route::get('change/status', [OrderBoardController::class, 'changeStatus'])->name('changeStatus');
    });

    // sale information
    Route::prefix('saleInfo')->group(function(){
        Route::get('list', [SaleInformationController::class, 'list'])->name('saleList');
    });

});