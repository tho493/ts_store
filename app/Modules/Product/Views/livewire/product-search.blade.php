<div class="relative w-full">
    <form wire:submit.prevent="search" class="relative flex items-center">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            placeholder="Tìm kiếm pin (laptop, điện thoại, sạc dự phòng...)" 
            class="w-full bg-[#F7F7F7] text-sm text-[#111111] placeholder-[#666666] border border-[#ECECEC] rounded px-4 py-2 pl-10 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition-all duration-200"
        />
        <div class="absolute left-3 text-[#666666]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        
        <!-- Loading Indicator -->
        <div wire:loading wire:target="query" class="absolute right-3">
            <svg class="animate-spin h-4 w-4 text-[#2E9F5B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </form>

    <!-- Dropdown Kết quả gợi ý nhanh (Backdrop Blur) -->
    @if(!empty($results))
        <div class="absolute left-0 right-0 mt-2 z-50 bg-white/95 backdrop-blur-md border border-[#ECECEC] rounded shadow-xl max-h-80 overflow-y-auto divide-y divide-[#ECECEC] transition-all duration-200">
            @foreach($results as $product)
                <a href="/products/{{ $product->slug }}" class="flex items-center gap-3 p-3 hover:bg-[#F7F7F7] transition-colors duration-150">
                    <div class="w-10 h-10 bg-[#F7F7F7] border border-[#ECECEC] rounded flex-shrink-0 flex items-center justify-center p-1">
                        <!-- Trong thực tế có ảnh, ở đây render text/placeholder nếu chưa có ảnh -->
                        <span class="text-[10px] font-bold text-[#666666] uppercase">TS</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-semibold text-[#111111] truncate">{{ $product->name }}</h4>
                        <p class="text-[10px] text-[#666666] truncate">SKU: {{ $product->sku }}</p>
                    </div>
                    <div class="text-right">
                        @if($product->sale_price)
                            <span class="text-xs font-bold text-[#2E9F5B]">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                            <span class="block text-[9px] text-[#666666] line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        @else
                            <span class="text-xs font-bold text-[#111111]">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
