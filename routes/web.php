<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OutboundController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SupplierController;
use App\Http\Middleware\AuthLogin;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/', 'loginPost')->name('loginPost');
});

Route::middleware(AuthLogin::class)->group(function () {
    Route::prefix('/dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::prefix('/warehouse')->controller(WarehouseController::class)->group(function () {
        Route::get('/', 'index')->name('warehouse.index');
        Route::post('/', 'store')->name('warehouse.store');
    });

    Route::prefix('/supplier')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('supplier.index');
        Route::post('/', 'store')->name('supplier.store');
        Route::get('/find', 'find')->name('supplier.find');
        Route::post('/update', 'update')->name('supplier.update');
        Route::get('/delete', 'delete')->name('supplier.delete');
    });

    Route::prefix('/material')->controller(MaterialController::class)->group(function () {
        Route::get('/', 'index')->name('material.index');
        Route::post('/', 'store')->name('material.store');
        Route::get('/find', 'find')->name('material.find');
        Route::post('/update', 'update')->name('material.update');
        Route::get('/delete', 'delete')->name('material.delete');
    });

    Route::prefix('/purchase-order')->controller(PurchaseOrderController::class)->group(function () {
        Route::get('/', 'index')->name('purchase_order.index');
        Route::get('/create', 'create')->name('purchase_order.create');
        Route::post('/', 'store')->name('purchase_order.store');
        Route::get('/detail', 'detail')->name('purchase_order.detail');

        Route::get('/process', 'approvePurchaseOrder')->name('purchase_order.process');
        Route::get('/cancel', 'cancelPurchaseOrder')->name('purchase_order.cancel');
    });

    Route::prefix('/inventory')->controller(InventoryController::class)->group(function () {
        Route::get('/', 'index')->name('inventory.index');
        Route::get('/detail', 'detail')->name('inventory.detail');
    });

    Route::prefix('/outbound')->controller(OutboundController::class)->group(function () {
        Route::get('/', 'index')->name('outbound.index');
        Route::get('/detail', 'detail')->name('outbound.detail');
        Route::get('/process', 'process')->name('outbound.process');
        Route::get('/cancel', 'cancel')->name('outbound.cancel');
    });
});
