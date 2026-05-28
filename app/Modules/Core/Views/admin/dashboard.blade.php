@extends('core::admin.layout')

@section('page_title', 'Dashboard & Cấu hình')

@section('admin_content')
<div class="flex flex-col gap-8">
    
    <!-- STATS CARDS -->
    <div class="grid grid-cols-3 gap-3 sm:gap-6">
        <!-- Tổng sản phẩm -->
        <div class="bg-white border border-[#ECECEC] rounded p-4 sm:p-6 flex flex-col gap-1 sm:gap-2">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-[#666666]">Sản phẩm</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-[#111111] font-outfit">{{ $totalProducts }}</span>
        </div>
        <!-- Tổng đơn hàng -->
        <div class="bg-white border border-[#ECECEC] rounded p-4 sm:p-6 flex flex-col gap-1 sm:gap-2">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-[#666666]">Đơn hàng</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-[#111111] font-outfit">{{ $totalOrders }}</span>
        </div>
        <!-- Doanh thu hoàn thành -->
        <div class="bg-white border border-[#ECECEC] rounded p-4 sm:p-6 flex flex-col gap-1 sm:gap-2">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-[#666666]">Doanh thu</span>
            <span class="text-lg sm:text-2xl md:text-3xl font-extrabold text-[#2E9F5B] font-outfit leading-tight">{{ number_format($revenue, 0, ',', '.') }}đ</span>
        </div>
    </div>

    <!-- CONFIGURATION FORM & STOCK ALERT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Cột trái: Form cấu hình hệ thống (7/12) -->
        <div class="lg:col-span-7 bg-white border border-[#ECECEC] rounded p-6 flex flex-col gap-6">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] pb-2 border-b border-[#F7F7F7]">Cấu hình hệ thống</h3>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <!-- Bật/Tắt giỏ hàng (Toggle) -->
                <div class="flex items-center justify-between p-4 bg-[#F7F7F7] border border-[#ECECEC] rounded">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs font-bold text-[#111111]">Chức năng giỏ hàng & Thanh toán</span>
                        <span class="text-[10px] text-[#666666]">Nếu tắt, hệ thống chỉ hiển thị nút liên hệ và ẩn giỏ hàng.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_shopping_cart" class="sr-only peer" @if(setting('enable_shopping_cart', true)) checked @endif>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2E9F5B]"></div>
                    </label>
                </div>

                <!-- Hotline -->
                <div class="flex flex-col gap-1.5">
                    <label for="hotline" class="text-xs font-semibold text-[#111111]">Số điện thoại Hotline</label>
                    <input 
                        type="text" 
                        id="hotline" 
                        name="hotline" 
                        value="{{ setting('hotline', '0987.654.321') }}"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    />
                </div>

                <!-- Zalo link -->
                <div class="flex flex-col gap-1.5">
                    <label for="zalo_link" class="text-xs font-semibold text-[#111111]">Đường dẫn Zalo liên hệ</label>
                    <input 
                        type="text" 
                        id="zalo_link" 
                        name="zalo_link" 
                        value="{{ setting('zalo_link', 'https://zalo.me/0987654321') }}"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    />
                </div>

                <!-- Messenger link -->
                <div class="flex flex-col gap-1.5">
                    <label for="messenger_link" class="text-xs font-semibold text-[#111111]">Đường dẫn Facebook Messenger</label>
                    <input 
                        type="text" 
                        id="messenger_link" 
                        name="messenger_link" 
                        value="{{ setting('messenger_link', 'https://m.me/tsbattery') }}"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    />
                </div>

                <!-- Address -->
                <div class="flex flex-col gap-1.5">
                    <label for="address" class="text-xs font-semibold text-[#111111]">Địa chỉ hiển thị ở chân trang</label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address" 
                        value="{{ setting('address', '123 Đường Năng Lượng, Hà Nội') }}"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    />
                </div>

                <button type="submit" class="bg-[#2E9F5B] text-white py-2.5 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#238247] transition">
                    Lưu cấu hình
                </button>
            </form>
        </div>

        <!-- Cột phải: Cảnh báo tồn kho thấp (5/12) -->
        <div class="lg:col-span-5 bg-white border border-[#ECECEC] rounded p-6 flex flex-col gap-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] pb-2 border-b border-[#F7F7F7]">Cảnh báo tồn kho thấp (&lt; 10)</h3>
            
            @if($lowStockProducts->isEmpty())
                <p class="text-xs text-[#666666] py-4 text-center">Tồn kho của các sản phẩm hiện tại đều an toàn.</p>
            @else
                <div class="flex flex-col gap-3">
                    @foreach($lowStockProducts as $prod)
                        <div class="flex items-center justify-between text-xs py-2 border-b border-[#F7F7F7] last:border-0">
                            <div class="flex flex-col">
                                <span class="font-bold text-[#111111] truncate max-w-[200px]">{{ $prod->name }}</span>
                                <span class="text-[10px] text-[#666666]">SKU: {{ $prod->sku }}</span>
                            </div>
                            <span class="bg-red-50 text-red-700 px-2 py-0.5 border border-red-200 rounded font-bold">
                                Chỉ còn: {{ $prod->stock }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
