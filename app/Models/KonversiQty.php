<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonversiQty extends Model
{
    protected $table = 'konversi_qty';
    protected $fillable = ['konversi_key', 'satuan', 'konversi', 'terkecil'];
}
