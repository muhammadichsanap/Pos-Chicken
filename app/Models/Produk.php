<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Sesuaikan dengan nama tabel 

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'gambar_produk',
        'kategori_produk_id',
    ];

    /**
     * Relasi ke KategoriProduk.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }
}
