<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $table = 'kategori_produk'; // Nama tabel sesuai database
    protected $fillable = ['nama_kategori']; // Kolom yang bisa diisi

    /**
     * Relasi ke Produk.
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_produk_id');
    }
}
