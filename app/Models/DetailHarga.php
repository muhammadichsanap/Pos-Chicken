<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailHarga extends Model
{
    use HasFactory;

    protected $table = 'detail_harga'; // Nama tabel sesuai database
    protected $fillable = ['produk_id', 'ukuran_produk', 'harga_produk']; // Kolom yang bisa diisi

    /**
     * Relasi ke Produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
