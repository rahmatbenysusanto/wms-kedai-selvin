<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $supplier = Supplier::get();

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
}
