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
        Schema::create('detail_penyewaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penyewaan');
            $table->unsignedBigInteger('id_alat');
            $table->integer('jumlah_hari');
            $table->integer('jumlah_alat');
            $table->integer('subtotal');
            $table->timestamps();
    
            $table->foreign('id_penyewaan')->references('id_penyewaan')->on('penyewaans')->onDelete('cascade');
            $table->foreign('id_alat')->references('id_alat')->on('alats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penyewaans');
    }
};
