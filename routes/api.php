<?php

use App\Http\Controllers\OutboundController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/warehouse')->controller(WarehouseController::class)->group(function () {
    Route::get('/', 'warehouse');
});

Route::prefix('/outbound')->controller(OutboundController::class)->group(function () {
    Route::post('/', 'store')->name('outbound.store');
});
