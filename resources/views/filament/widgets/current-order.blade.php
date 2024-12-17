<x-filament::widget>
    <x-filament::card>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">Current Order</h2>
            </div>

            <div class="text-sm text-gray-600">
                <p>Date: {{ now()->format('l, H:i A d/m/Y') }}</p>
                <p>Code: POS-{{ strtoupper(uniqid()) }}</p>
            </div>

            @if(count($cart) > 0)
                <div class="space-y-4 mt-4">
                    @foreach($cart as $index => $item)
                        <div class="flex items-start space-x-4">
                            <img src="{{ Storage::url($item['gambar_produk']) }}" 
                                 class="w-16 h-16 rounded-lg object-cover" />
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">{{ $item['nama_produk'] }}</h3>
                                    </div>
                                    <p class="font-semibold text-primary-600">Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="decrementQuantity({{ $index }})" 
                                                class="text-gray-400 hover:text-gray-600">
                                            <x-heroicon-s-minus-circle class="w-5 h-5" />
                                        </button>
                                        <span class="font-medium">{{ $item['jumlah'] }}</span>
                                        <button wire:click="incrementQuantity({{ $index }})"
                                                class="text-primary-600 hover:text-primary-700">
                                            <x-heroicon-s-plus-circle class="w-5 h-5" />
                                        </button>
                                    </div>
                                    <button wire:click="removeItem({{ $index }})" 
                                            class="text-red-500 hover:text-red-700">
                                        <x-heroicon-s-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span>Rp{{ number_format(collect($cart)->sum('total_harga'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax 10%</span>
                            <span>Rp{{ number_format(collect($cart)->sum('total_harga') * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Discount</span>
                            <span>-Rp6.000</span>
                        </div>
                        <div class="flex justify-between font-bold pt-2 border-t">
                            <span>Total</span>
                            <span>Rp{{ number_format((collect($cart)->sum('total_harga') * 1.1) - 6000, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <x-filament::button
                        wire:click="createOrder"
                        class="w-full"
                        color="primary"
                    >
                        Buat Pesanan
                    </x-filament::button>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    Keranjang kosong
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget> 