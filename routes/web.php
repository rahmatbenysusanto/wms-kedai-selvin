<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/warehouse')->controller(WarehouseController::class)->group(function () {
    Route::get('/', 'index')->name('warehouse.index');
    Route::post('/', 'store')->name('warehouse.store');
});

Route::prefix('/supplier')->controller(SupplierController::class)->group(function () {
    Route::get('/', 'index')->name('supplier.index');
    Route::post('/', 'store')->name('supplier.store');
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

    Route::get('/process', 'approvePurchaseOrder')->name('purchase_order.process');
    Route::get('/cancel', 'cancelPurchaseOrder')->name('purchase_order.cancel');
});

Route::prefix('/inventory')->controller(InventoryController::class)->group(function () {
    Route::get('/', 'index')->name('inventory.index');
});

Route::prefix('/api')->group(function () {
    Route::prefix('/warehouse')->controller(WarehouseController::class)->group(function () {
        Route::get('/', 'warehouse');
    });
});
