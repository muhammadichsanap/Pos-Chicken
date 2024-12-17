<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Models\PesananProduk;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class SidebarCart extends Component
{
    public $isOpen = false;
    public $cart = [];
    
    protected $listeners = [
        'cart-updated' => 'updateCart',
        'add-to-cart' => 'addToCart'
    ];

    public function mount()
    {
        $this->cart = CartService::get();
    }

    public function addToCart($data)
    {
        $this->isOpen = true; // Buka sidebar saat item ditambahkan
        
        CartService::add([
            'produk_id' => $data['id'],
            'nama_produk' => $data['nama'],
            'gambar_produk' => $data['gambar'],
            'harga' => $data['harga'],
            'jumlah' => 1,
            'total_harga' => $data['harga'],
            'catatan' => null,
        ]);

        $this->cart = CartService::get();

        Notification::make()
            ->success()
            ->title('Produk ditambahkan ke keranjang')
            ->send();
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

        $orderNumber = 'POS-' . Str::upper(Str::random(8));
        
        foreach ($this->cart as $item) {
            PesananProduk::create([
                'user_id' => auth()->id(),
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
                'total_harga' => $item['total_harga'],
                'catatan' => $item['catatan'],
                'status_pesanan' => 'pending',
                'nomor_pesanan' => $orderNumber,
                'tanggal_pesanan' => now(),
            ]);
        }

        CartService::clear();
        $this->cart = [];
        $this->isOpen = false;
        
        Notification::make()
            ->success()
            ->title('Pesanan berhasil dibuat')
            ->body('Nomor Pesanan: ' . $orderNumber)
            ->send();
    }

    public function updateCart()
    {
        $this->cart = CartService::get();
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

    public function removeItem($index)
    {
        CartService::remove($index);
        $this->cart = CartService::get();
    }

    public function getSubtotal()
    {
        return collect($this->cart)->sum('total_harga');
    }

    public function getTax()
    {
        return $this->getSubtotal() * 0.1;
    }

    public function getDiscount()
    {
        return 6000.00;
    }

    public function getTotal()
    {
        return $this->getSubtotal() + $this->getTax() - $this->getDiscount();
    }

    public function checkout()
    {
        // ... kode checkout sama seperti sebelumnya ...
    }

    public function render()
    {
        return view('livewire.sidebar-cart');
    }
} 