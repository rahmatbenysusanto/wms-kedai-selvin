<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Material;
use App\Models\Outbound;
use App\Models\OutboundDetail;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class OutboundController extends Controller
{
    public function index(Request $request): View
    {
        $outbound = Outbound::where('warehouse_id', 1)
            ->when($request->query('number'), function ($query) use ($request) {
                return $query->where('outlet_po_number', $request->query('number'));
            })
            ->paginate(10)
            ->appends([
                'number' => $request->query('number'),
            ]);

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

    /**
     * @throws ConnectionException
     */
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
        Http::baseUrl(env('URL_POS'))
            ->post('/process-po', [
                'po_number' => $outbound->outlet_po_number,
            ]);

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
                'status'            => 'Open'
            ]);

            foreach ($request->post('material') as $material) {
                $materialWMS = Material::where('sku', $material['sku'])->first();

                OutboundDetail::create([
                    'outbound_id'   => $outbound->id,
                    'material_id'   => $materialWMS->id,
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
