<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Services\CartService;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;

class CurrentOrderWidget extends Widget
{
    protected static string $view = 'filament.widgets.current-order';
    
    public $cart = [];
    
    public function mount()
    {
        $this->cart = CartService::get();
    }

    #[On('addToCart')]
    public function addToCart($id, $nama, $harga, $gambar)
    {
        // Periksa apakah $gambar kosong, jika iya gunakan nilai default
        $gambar = $gambar ?? 'default-image.jpg'; // Ganti dengan gambar default yang Anda miliki

        CartService::add([
            'produk_id' => $id,
            'nama_produk' => $nama,
            'gambar_produk' => $gambar,
            'harga' => $harga,
            'jumlah' => 1,
            'total_harga' => $harga,
        ]);

        $this->cart = CartService::get();

        Notification::make()
            ->success()
            ->title('Produk ditambahkan ke keranjang')
            ->send();
    }


    public function removeItem($index)
    {
        CartService::remove($index);
        $this->cart = CartService::get();

        Notification::make()
            ->success()
            ->title('Produk dihapus dari keranjang')
            ->send();
    }

    public function incrementQuantity($index)
    {
        $this->cart[$index]['jumlah']++;
        $this->cart[$index]['total_harga'] = $this->cart[$index]['jumlah'] * $this->cart[$index]['harga'];
        CartService::set($this->cart);
    }

    public function decrementQuantity($index)
    {
        if ($this->cart[$index]['jumlah'] > 1) {
            $this->cart[$index]['jumlah']--;
            $this->cart[$index]['total_harga'] = $this->cart[$index]['jumlah'] * $this->cart[$index]['harga'];
            CartService::set($this->cart);
        }
    }

    public function createOrder()
    {
        if (empty($this->cart)) {
            Notification::make()
                ->warning()
                ->title('Keranjang kosong')
                ->send();
            return;
        }

        // Buat pesanan
        $orderNumber = 'POS-' . strtoupper(uniqid());
        
        foreach ($this->cart as $item) {
            \App\Models\PesananProduk::create([
                'user_id' => auth()->id(),
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
                'total_harga' => $item['total_harga'],
                'status_pesanan' => 'pending',
                'nomor_pesanan' => $orderNumber,
                'tanggal_pesanan' => now(),
            ]);
        }

        // Bersihkan keranjang
        CartService::clear();
        $this->cart = [];

        Notification::make()
            ->success()
            ->title('Pesanan berhasil dibuat')
            ->body('Nomor Pesanan: ' . $orderNumber)
            ->send();
    }
} 