<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $supplier = Supplier::whereNull('deleted_at')
            ->when($request->query('name'), function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->query('name') . '%');
            })
            ->paginate(10)
            ->appends([
                'name' => $request->query('name'),
            ]);

        $title = 'Supplier';
        return view('supplier.index', compact('title', 'supplier'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Supplier::create([
            'name'      => $request->post('name'),
            'address'   => $request->post('address'),
            'status'    => 'active',
        ]);

        return redirect()->back()->with('success', 'Supplier created successfully');
    }

    public function find(Request $request): \Illuminate\Http\JsonResponse
    {
        $supplier = Supplier::find($request->get('id'));

        return response()->json([
            'data' => $supplier,
        ]);
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        Supplier::where('id', $request->post('id'))->update([
            'name'      => $request->post('name'),
            'address'   => $request->post('address'),
        ]);

        return redirect()->back()->with('success', 'Supplier updated successfully');
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        Supplier::where('id', $request->get('id'))->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'status' => true
        ]);
    }
}
