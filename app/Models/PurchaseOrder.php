<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    protected $fillable = [
        'warehouse_id',
        'supplier_id',
        'number',
        'status',
        'qty'
    ];
}
