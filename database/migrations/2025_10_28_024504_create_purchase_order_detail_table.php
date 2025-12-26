<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->integer('material_id');
            $table->integer('qty');
            $table->integer('satuan_id');
            $table->integer('reff_qty');
            $table->integer('reff_satuan_id');
            $table->decimal('price', 9, 2)->default(0);
            $table->integer('price_satuan_id');
            $table->decimal('total', 9, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_detail');
    }
};
