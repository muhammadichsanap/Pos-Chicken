<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Sesuaikan dengan nama tabel 

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'gambar_produk',
        'harga',
        'ukuran',
        'kategori_produk_id'
    ];

    /**
     * Relasi ke KategoriProduk.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    /**
     * Relasi ke PesananProduk.
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(PesananProduk::class);
    }
}
