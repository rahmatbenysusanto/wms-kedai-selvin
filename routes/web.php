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

Route::prefix('/purchase_order')->controller(PurchaseOrderController::class)->group(function () {

});

Route::prefix('/inventory')->controller(InventoryController::class)->group(function () {

});

Route::prefix('/api')->group(function () {
    Route::prefix('/warehouse')->controller(WarehouseController::class)->group(function () {
        Route::get('/', 'warehouse');
    });
});
