<x-filament::widget>
    <x-filament::card>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">Current Order</h2>
                <button class="text-gray-400 hover:text-gray-600">
                    <x-heroicon-o-ellipsis-horizontal class="w-6 h-6" />
                </button>
            </div>

            <div class="text-sm text-gray-600">
                <p>Date: {{ now()->format('l, H:i A d/m/Y') }}</p>
                <p>Code: POS-{{ strtoupper(uniqid()) }}</p>
            </div>

            <div class="space-y-4 mt-4">
                @forelse($cart as $index => $item)
                    <div class="flex items-start space-x-4">
                        <img src="{{ Storage::url($item['gambar_produk']) }}" 
                             class="w-16 h-16 rounded-lg object-cover" />
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium">{{ $item['nama_produk'] }}</h3>
                                    <p class="text-sm text-gray-500">{{ Str::limit($item['catatan'] ?? 'Special instructions...', 30) }}</p>
                                </div>
                                <p class="font-semibold text-primary-600">${{ number_format($item['total_harga'], 1) }}</p>
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
                @empty
                    <div class="text-center py-4 text-gray-500">
                        Keranjang kosong
                    </div>
                @endforelse
            </div>

            @if(count($cart) > 0)
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span>${{ number_format($this->getSubtotal(), 1) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax 10%</span>
                        <span>${{ number_format($this->getTax(), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount</span>
                        <span>-${{ number_format($this->getDiscount(), 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold pt-2">
                        <span>Total</span>
                        <span>${{ number_format($this->getTotal(), 2) }}</span>
                    </div>
                </div>

                <x-filament::button
                    wire:click="checkout"
                    class="w-full justify-center py-2.5"
                    color="primary"
                >
                    Continue to Payment
                </x-filament::button>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget> 