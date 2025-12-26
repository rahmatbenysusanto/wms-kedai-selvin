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
        Schema::create('konversi_qty', function (Blueprint $table) {
            $table->id();
            $table->integer('konversi_key');
            $table->string('satuan');
            $table->integer('konversi');
            $table->enum('terkecil', ['N', 'Y'])->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konversi_qty');
    }
};
