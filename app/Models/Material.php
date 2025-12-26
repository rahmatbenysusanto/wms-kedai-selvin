<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $table = 'material';
    protected $fillable = [
        'warehouse_id',
        'sku',
        'name',
        'category_id',
        'satuan',
        'min_stock',
        'deleted_at'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function konversi(): BelongsTo
    {
        return $this->belongsTo(KonversiQty::class, 'satuan', 'id');
    }
}
