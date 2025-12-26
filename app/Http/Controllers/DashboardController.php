<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $lowStockProducts = DB::table('inventory')
            ->leftJoin('material', 'material.id', '=', 'inventory.material_id')
            ->where('inventory.stock', '<=', 'material.min_stock')
            ->select([
                'material.name',
                'material.sku',
                'inventory.stock',
            ])
            ->limit(5)
            ->get();

        $title = 'Dashboard';
        return view('dashboard.index', compact('title', 'lowStockProducts'));
    }
}
