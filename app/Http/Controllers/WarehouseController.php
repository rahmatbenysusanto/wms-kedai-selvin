<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function index(): View
    {
        $warehouse = Warehouse::where('status', 'active')->paginate(10);

        $title = 'Warehouse';
        return view('warehouse.index', compact('title', 'warehouse'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Warehouse::create([
            'name'      => $request->post('name'),
            'address'   => $request->post('address'),
            'status'    => 'active',
        ]);

        return redirect()->back()->with('success', 'Warehouse created successfully');
    }

    public function warehouse(): \Illuminate\Http\JsonResponse
    {
        $warehouse = Warehouse::where('status', 'active')->get();

        return response()->json([
            'status'    => true,
            'message'   => 'Get Warehouse Successfully',
            'data'      => $warehouse
        ]);
    }
}
