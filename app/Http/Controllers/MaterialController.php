<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $title = 'Material';
        return view('material.index', compact('title'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Material::create([
            'warehouse_id'  => 1,
            'sku'           => $request->post('sku'),
            'name'          => $request->post('name'),
            'category_id'   => $request->post('category_id'),
            'satuan'        => $request->post('satuan'),
        ]);

        return redirect()->back()->with('success', 'Create Material Successfully');
    }

    public function find(Request $request): \Illuminate\Http\JsonResponse
    {
        $material = Material::with('category')->where('id', $request->get('id'))->first();

        return response()->json([
            'success' => true,
            'data'    => $material,
        ]);
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        Material::where('id', $request->post('id'))->update([
            'sku'           => $request->post('sku'),
            'name'          => $request->post('name'),
            'category_id'   => $request->post('category_id'),
            'satuan'        => $request->post('satuan'),
        ]);

        return redirect()->back()->with('success', 'Update Material Successfully');
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        Material::where('id', $request->get('id'))
            ->update([
                'deleted_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
