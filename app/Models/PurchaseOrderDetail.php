<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_detail';
    protected $fillable = [
        'purchase_order_id',
        'material_id',
        'qty',
        'satuan_id',
        'reff_qty',
        'reff_satuan_id',
        'price',
        'price_satuan_id',
        'total'
    ];

    public function material(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function purchaseOrder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function konversiQty(): BelongsTo
    {
        return $this->belongsTo(KonversiQty::class, 'satuan_id', 'id');
    }

    public function reffKonversiQty(): BelongsTo
    {
        return $this->belongsTo(KonversiQty::class, 'reff_satuan_id', 'id');
    }
}
