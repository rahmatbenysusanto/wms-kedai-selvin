<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $inventory = Inventory::with('material', 'material.category')
            ->where('warehouse_id', 1)
            ->whereHas('material', function ($query) use ($request) {
                if ($request->query('sku')) {
                    $query->where('sku', $request->query('sku'));
                }

                if ($request->query('material')) {
                    $query->where('name', $request->query('material'));
                }

                if ($request->query('category')) {
                    $query->where('category_id', $request->query('category'));
                }
            })
            ->paginate(10)
            ->appends([
                'category'  => $request->query('category'),
                'sku'       => $request->query('sku'),
                'material'  => $request->query('material'),
            ]);

        $category = Category::all();

        $title = 'Inventory';
        return view('inventory.index', compact('title', 'inventory', 'category'));
    }

    public function detail(Request $request): View
    {
        $inventoryDetail = InventoryDetail::with('material', 'material.category', 'purchaseOrderDetail', 'purchaseOrderDetail.purchaseOrder')->where('inventory_id', $request->query('id'))->get();

        $title = 'Inventory';
        return view('inventory.detail', compact('title', 'inventoryDetail'));
    }
}
