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
        Schema::create('outbound_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outbound_id');
            $table->integer('material_id');
            $table->decimal('qty', 9, 2)->default(0);
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbound_detail');
    }
};
