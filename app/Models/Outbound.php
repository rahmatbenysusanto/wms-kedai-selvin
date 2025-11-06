<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    protected $table = 'outbound';
    protected $fillable = [
        'warehouse_id',
        'outlet',
        'outlet_po_number',
        'qty',
        'status'
    ];

    public function outboundDetail(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OutboundDetail::class);
    }
}
