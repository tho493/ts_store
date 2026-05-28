<div class="bg-white border border-[#ECECEC] rounded overflow-hidden flex flex-col hover:scale-[1.02] transition-all duration-200">
    <!-- Ảnh sản phẩm -->
    <a href="/products/{{ $product->slug }}" class="block aspect-square bg-[#F7F7F7] relative flex items-center justify-center p-4 sm:p-6 border-b border-[#ECECEC]">
        <div class="flex flex-col items-center justify-center text-center">
            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-[#2E9F5B]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
            </svg>
            <span class="text-[8px] sm:text-[10px] font-bold text-[#666666] uppercase mt-1 sm:mt-2">TS BATTERY</span>
        </div>
        
        <!-- Nhãn giảm giá (nếu có) -->
        @if($product->sale_price)
            <span class="absolute top-2 left-2 bg-[#2E9F5B] text-white text-[8px] sm:text-[9px] font-bold px-1.5 py-0.5 rounded">
                GIẢM
            </span>
        @endif
    </a>

    <!-- Chi tiết sản phẩm -->
    <div class="p-3 sm:p-5 flex-1 flex flex-col justify-between gap-3">
        <div>
            <!-- Danh mục -->
            <span class="text-[8px] sm:text-[9px] font-bold uppercase tracking-wider text-[#666666]">
                {{ $product->category->name ?? 'Pin' }}
            </span>
            <!-- Tên -->
            <a href="/products/{{ $product->slug }}" class="block mt-0.5 sm:mt-1 text-xs sm:text-sm font-bold text-[#111111] hover:text-[#2E9F5B] line-clamp-2 transition-colors duration-150 leading-snug">
                {{ $product->name }}
            </a>
            
            <!-- Thông số kỹ thuật - ẩn trên mobile nhỏ -->
            @if(!empty($product->specifications))
                <div class="mt-2 hidden sm:flex flex-wrap gap-x-3 gap-y-1">
                    @if(isset($product->specifications['Dung lượng']))
                        <span class="text-[10px] text-[#666666]">
                            <strong class="text-[#111111] font-medium">Dung lượng:</strong> {{ $product->specifications['Dung lượng'] }}
                        </span>
                    @endif
                    @if(isset($product->specifications['Điện áp']))
                        <span class="text-[10px] text-[#666666]">
                            <strong class="text-[#111111] font-medium">Điện áp:</strong> {{ $product->specifications['Điện áp'] }}
                        </span>
                    </span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Giá bán & Nút CTA -->
        <div class="flex items-center justify-between pt-2 border-t border-[#F7F7F7]">
            <div class="flex flex-col">
                @if($product->sale_price)
                    <span class="text-xs sm:text-sm font-bold text-[#2E9F5B]">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                    <span class="text-[9px] sm:text-[10px] text-[#666666] line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @else
                    <span class="text-xs sm:text-sm font-bold text-[#111111]">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @endif
            </div>

            <!-- Nút mua hàng / liên hệ động -->
            @if(setting('enable_shopping_cart', true))
                <button 
                    wire:click="addToCart({{ $product->id }})" 
                    class="bg-[#2E9F5B] text-white hover:bg-[#238247] p-1.5 sm:p-2 rounded focus:outline-none transition-colors duration-200"
                    title="Thêm vào giỏ hàng"
                >
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                    </svg>
                </button>
            @else
                <a 
                    href="{{ setting('zalo_link', '#') }}" 
                    target="_blank" 
                    class="border border-[#2E9F5B] text-[#2E9F5B] hover:bg-[#F0FDF4] text-[9px] sm:text-[10px] font-bold uppercase tracking-wider px-2 sm:px-3 py-1 sm:py-1.5 rounded transition-colors duration-200"
                >
                    Liên hệ
                </a>
            @endif
        </div>
    </div>
</div>
