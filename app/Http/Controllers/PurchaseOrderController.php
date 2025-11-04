<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Material;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $purchaseOrder = PurchaseOrder::where('warehouse_id', 1)->paginate(10);

        $title = 'Purchase Order';
        return view('purchaseOrder.index', compact('title', 'purchaseOrder'));
    }

    public function create(): View
    {
        $suppliers = Supplier::all();
        $material = Material::where('warehouse_id', 1)->get();

        $title = 'Purchase Order';
        return view('purchaseOrder.create', compact('title', 'suppliers', 'material'));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::create([
                'warehouse_id'  => 1,
                'supplier_id'   => $request->post('supplier'),
                'number'        => 'PO-'.date('YmdHis').rand(100, 999),
                'qty'           => count($request->post('material')),
                'status'        => 'Pending',
            ]);

            foreach ($request->post('material') as $material) {
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'material_id'       => $material['id'],
                    'qty'               => $material['qty'],
                    'price'             => $material['price'],
                    'total'             => $material['qty'] * $material['price'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function detail(Request $request): View
    {
        $purchaseOrder = PurchaseOrder::with('supplier')->where('id', $request->query('id'));
        $purchaseOrderDetail = PurchaseOrderDetail::with('material', 'material.category')->where('purchase_order_id', $purchaseOrder->id)->get();

        $title = 'Purchase Order';
        return view('purchaseOrder.detail', compact('title', 'purchaseOrder', 'purchaseOrderDetail'));
    }

    public function cancelPurchaseOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        PurchaseOrder::where('id', $request->get('id'))->update([
            'status' => 'Cancel',
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function approvePurchaseOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            PurchaseOrder::where('id', $request->get('id'))->update([
                'status' => 'Done',
            ]);

            $purchaseOrder = PurchaseOrder::find($request->get('id'));
            $purchaseOrderDetail = PurchaseOrderDetail::where('purchase_order_id', $purchaseOrder->id)->get();

            foreach ($purchaseOrderDetail as $detail) {
                Inventory::where('warehouse_id', $purchaseOrder->warehouse_id)
                    ->where('material_id', $detail->material_id)
                    ->increment('stock', $detail->qty);

                $inventory = Inventory::where('warehouse_id', $purchaseOrder->warehouse_id)->where('material_id', $detail->material_id)->first();
                InventoryDetail::create([
                    'inventory_id'              => $inventory->id,
                    'purchase_order_detail_id'  => $detail->id,
                    'qty'                       => $detail->qty,
                    'price'                     => $detail->price,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
