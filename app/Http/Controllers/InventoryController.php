<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $inventory = Inventory::with('material', 'material.category')->where('warehouse_id', 1)->paginate(10);

        $title = 'Inventory';
        return view('inventory.index', compact('title', 'inventory'));
    }

    public function detail(Request $request): View
    {
        $inventoryDetail = InventoryDetail::with('material', 'material.category', 'purchaseOrderDetail', 'purchaseOrderDetail.purchaseOrder')->where('inventory_id', $request->query('id'))->get();

        $title = 'Inventory';
        return view('inventory.detail', compact('title', 'inventoryDetail'));
    }
}
