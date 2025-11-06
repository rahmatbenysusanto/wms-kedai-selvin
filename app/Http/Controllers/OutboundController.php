<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Outbound;
use App\Models\OutboundDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OutboundController extends Controller
{
    public function index(): View
    {
        $outbound = Outbound::where('warehouse_id', 1)->paginate(10);

        $title = 'Outbound';
        return view('outbound.index', compact('title', 'outbound'));
    }

    public function detail(Request $request): View
    {
        $outbound = Outbound::find($request->query('id'));
        $outboundDetail = OutboundDetail::with('material')->where('outbound_id', $request->query('id'))->get();

        $title = 'Outbound';
        return view('outbound.detail', compact('title', 'outbound', 'outboundDetail'));
    }

    public function process(Request $request): \Illuminate\Http\JsonResponse
    {
        Outbound::where('id', $request->query('id'))->update([
            'status' => 'Close'
        ]);

        $outbound = Outbound::find($request->query('id'));
        $outboundDetail = OutboundDetail::where('outbound_id', $request->query('id'))->get();
        foreach ($outboundDetail as $detail) {
            Inventory::where('warehouse_id', $outbound->warehouse_id)
                ->where('material_id', $detail->material_id)
                ->decrement('stock', $detail->qty);
        }

        // Trigger ke POS


        return response()->json([
            'status' => true
        ]);
    }

    public function cancel(Request $request): \Illuminate\Http\JsonResponse
    {
        Outbound::where('id', $request->query('id'))->update([
            'status' => 'Cancel'
        ]);

        // Trigger ke POS

        return response()->json([
            'status' => true
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $outbound = Outbound::create([
                'warehouse_id'      => $request->post('warehouse_id'),
                'outlet'            => $request->post('outlet'),
                'outlet_po_number'  => $request->post('outlet_po_number'),
                'qty'               => $request->post('qty'),
                'status'            => 'New'
            ]);

            foreach ($request->post('material') as $material) {
                OutboundDetail::create([
                    'outbound_id'   => $outbound->id,
                    'material_id'   => $material['id'],
                    'qty'           => $material['qty'],
                    'satuan'        => $material['satuan'],
                ]);
            }

            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Created Purchase Order Successfully',
                'data'      => [],
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'Create Purchase Order Failed',
                'data'      => [],
            ]);
        }
    }
}
