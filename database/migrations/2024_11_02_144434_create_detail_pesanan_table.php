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
    Schema::create('detail_pesanan', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('order_id');
        $table->string('nama_pemesan');
        $table->integer('no_meja');
        $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
        $table->enum('status_pembayaran', ['sudah', 'belum']);
        $table->bigInteger('total_pembayaran');
        $table->enum('metode_pembayaran', ['Ots', 'Qris']);
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
