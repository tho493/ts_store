<div>
    <!-- Backdrop Overlay (Kính mờ) -->
    <div 
        wire:click="toggle"
        class="fixed inset-0 z-50 bg-black/15 backdrop-blur-sm transition-opacity duration-300 {{ $isOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }}"
    ></div>

    <!-- Sliding Cart Drawer Panel -->
    <div 
        class="fixed top-0 right-0 bottom-0 z-50 w-full max-w-md bg-white shadow-2xl transition-transform duration-300 transform flex flex-col {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}"
    >
        <!-- Header -->
        <div class="p-6 border-b border-[#ECECEC] flex items-center justify-between">
            <h3 class="text-lg font-bold tracking-tight text-[#111111] font-outfit uppercase">Giỏ hàng của bạn</h3>
            <button wire:click="toggle" class="p-1 text-[#666666] hover:text-[#111111] focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Cart Items List (Content) -->
        <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6">
            @if(empty($cart))
                <div class="flex-1 flex flex-col items-center justify-center text-center gap-4">
                    <div class="text-[#666666]">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-[#111111]">Giỏ hàng của bạn đang trống</h4>
                        <p class="text-xs text-[#666666] mt-1">Hãy khám phá thêm các sản phẩm pin của TS Battery.</p>
                    </div>
                    <button wire:click="toggle" class="mt-2 border border-[#111111] text-[#111111] text-xs font-semibold px-6 py-2.5 rounded hover:bg-[#111111] hover:text-white transition-colors duration-200 uppercase tracking-wider">
                        Tiếp tục mua sắm
                    </button>
                </div>
            @else
                <div class="flex flex-col gap-4">
                    @foreach($cart as $item)
                        <div class="flex gap-4 pb-4 border-b border-[#ECECEC]">
                            <!-- Product Image Placeholder -->
                            <div class="w-20 h-20 bg-[#F7F7F7] border border-[#ECECEC] rounded flex-shrink-0 flex items-center justify-center p-1">
                                <span class="text-xs font-bold text-[#666666] uppercase">TS.B</span>
                            </div>
                            
                            <!-- Item details -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-xs font-semibold text-[#111111] line-clamp-2">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] text-[#666666] mt-0.5">SKU: {{ $item['sku'] }}</p>
                                </div>
                                
                                <div class="flex items-center justify-between mt-2">
                                    <!-- Quantity controls -->
                                    <div class="flex items-center border border-[#ECECEC] rounded bg-[#F7F7F7]">
                                        <button 
                                            wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                            class="px-2 py-1 text-xs text-[#666666] hover:text-[#111111] focus:outline-none"
                                        >-</button>
                                        <span class="px-2 text-xs font-semibold text-[#111111]">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                            class="px-2 py-1 text-xs text-[#666666] hover:text-[#111111] focus:outline-none"
                                        >+</button>
                                    </div>
                                    
                                    <!-- Price / Remove -->
                                    <div class="text-right">
                                        <span class="text-xs font-bold text-[#2E9F5B]">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                                        <button 
                                            wire:click="removeItem({{ $item['id'] }})"
                                            class="block text-[10px] text-red-500 hover:underline mt-1 ml-auto"
                                        >Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if(!empty($cart))
            <div class="p-6 border-t border-[#ECECEC] bg-[#F7F7F7] flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-[#666666]">Tổng cộng:</span>
                    <span class="text-lg font-bold text-[#2E9F5B]">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                </div>
                <button 
                    wire:click="checkout"
                    class="w-full bg-[#2E9F5B] text-white py-3 rounded text-sm font-semibold uppercase tracking-wider hover:bg-[#238247] transition-colors duration-200 text-center"
                >
                    Tiến hành thanh toán
                </button>
            </div>
        @endif
    </div>
</div>
