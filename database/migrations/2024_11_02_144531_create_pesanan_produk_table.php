<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('pesanan_produk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pesanan_id')->constrained('detail_pesanan')->onDelete('cascade');
        $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
        $table->text('catatan_produk')->nullable();
        $table->integer('jumlah_produk');
        $table->bigInteger('subtotal');
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_produk');
    }
};
