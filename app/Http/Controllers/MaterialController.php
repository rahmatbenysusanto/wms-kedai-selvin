<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $material = Material::with('category')->where('warehouse_id', 1)->whereNull('deleted_at')->paginate(10);

        $category = Category::all();

        $title = 'Material';
        return view('material.index', compact('title', 'material', 'category'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Material::create([
            'warehouse_id'  => 1,
            'sku'           => $request->post('sku') ?? 'MN-' . strtoupper(Str::random(6)),
            'name'          => $request->post('name'),
            'category_id'   => $request->post('category'),
            'satuan'        => $request->post('satuan'),
            'min_stock'     => $request->post('minStock'),
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
