<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('gambar_promo')->nullable(); // Gambar promo, optional
            $table->unsignedBigInteger('created_by'); // Foreign key for user who created promo
            $table->timestamps(); // created_at & updated_at fields

            // Add foreign key constraint (assuming 'user' table exists)
            $table->foreign('created_by')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo');
    }
}
