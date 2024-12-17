<?php

namespace App\Services;

class CartService
{
    /**
     * Ambil keranjang dari sesi
     */
    public static function get()
    {
        return session('cart', []);
    }

    /**
     * Tambahkan item ke keranjang
     */
    public static function addToCart(array $item)
    {
        $cart = session('cart', []);

        // Periksa apakah produk sudah ada di keranjang
        $found = false;
        foreach ($cart as &$cartItem) {
            if ($cartItem['id'] === $item['id']) {
                $cartItem['jumlah']++;
                $cartItem['total_harga'] = $cartItem['jumlah'] * $cartItem['harga'];
                $found = true;
                break;
            }
        }

        // Jika produk belum ada, tambahkan sebagai item baru
        if (!$found) {
            $item['jumlah'] = 1;
            $item['total_harga'] = $item['harga'];
            $cart[] = $item;
        }

        session(['cart' => $cart]);
    }

    /**
     * Menghapus item dari keranjang
     */
    public static function remove($index)
    {
        $cart = session('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
        }
        session(['cart' => $cart]);
    }

    /**
     * Bersihkan keranjang
     */
    public static function clear()
    {
        session(['cart' => []]);
    }
}
