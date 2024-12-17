<div 
    class="relative" 
    x-data
    x-on:add-to-cart.window="$wire.addToCart($event.detail)"
>
    <!-- Trigger Button -->
    <button 
        wire:click="$toggle('isOpen')"
        class="fixed top-4 right-4 z-50 bg-primary-600 text-white p-2 rounded-full shadow-lg hover:bg-primary-700 transition-colors"
    >
        <x-heroicon-s-shopping-cart class="w-6 h-6" />
        @if(count($cart) > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                {{ count($cart) }}
            </span>
        @endif
    </button>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 right-0 w-96 bg-white shadow-xl transform transition-transform duration-300 ease-in-out z-40 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="p-4 border-b flex justify-between items-center bg-primary-600 text-white">
                <h2 class="text-xl font-bold">Current Order</h2>
                <button wire:click="$set('isOpen', false)" class="text-white hover:text-gray-200">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <!-- Order Info -->
            <div class="px-4 py-2 bg-gray-50">
                <p class="text-sm text-gray-600">Date: {{ now()->format('l, H:i A d/m/Y') }}</p>
                <p class="text-sm text-gray-600">Code: POS-{{ strtoupper(uniqid()) }}</p>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                @forelse($cart as $index => $item)
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-start space-x-4">
                            <img src="{{ Storage::url($item['gambar_produk']) }}" 
                                 class="w-16 h-16 rounded-lg object-cover" />
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">{{ $item['nama_produk'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ Str::limit($item['catatan'] ?? 'No special instructions', 30) }}</p>
                                    </div>
                                    <p class="font-semibold text-primary-600">Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="decrementQuantity({{ $index }})" 
                                                class="text-gray-400 hover:text-gray-600">
                                            <x-heroicon-o-minus-circle class="w-6 h-6" />
                                        </button>
                                        <span class="font-medium">{{ $item['jumlah'] }}</span>
                                        <button wire:click="incrementQuantity({{ $index }})"
                                                class="text-primary-600 hover:text-primary-700">
                                            <x-heroicon-o-plus-circle class="w-6 h-6" />
                                        </button>
                                    </div>
                                    <button wire:click="removeItem({{ $index }})" 
                                            class="text-red-500 hover:text-red-700">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        Keranjang kosong
                    </div>
                @endforelse
            </div>

            <!-- Summary -->
            @if(count($cart) > 0)
                <div class="border-t bg-white p-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp{{ number_format($this->getSubtotal(), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax 10%</span>
                        <span>Rp{{ number_format($this->getTax(), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount</span>
                        <span>-Rp{{ number_format($this->getDiscount(), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold pt-2 border-t">
                        <span>Total</span>
                        <span>Rp{{ number_format($this->getTotal(), 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <button 
                            wire:click="$set('isOpen', false)"
                            class="w-full bg-gray-200 text-gray-800 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors"
                        >
                            Lanjut Belanja
                        </button>
                        <button 
                            wire:click="createOrder"
                            class="w-full bg-primary-600 text-white py-3 rounded-lg font-medium hover:bg-primary-700 transition-colors"
                        >
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Backdrop -->
    @if($isOpen)
        <div 
            class="fixed inset-0 bg-black bg-opacity-50 z-30"
            wire:click="$set('isOpen', false)"
        ></div>
    @endif
</div> 