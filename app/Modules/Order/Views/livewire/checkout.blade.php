<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    @if($orderPlaced)
        <!-- Giao diện đặt hàng thành công tối giản (Flat) -->
        <div class="max-w-xl mx-auto bg-white border border-[#ECECEC] rounded-lg p-8 text-center flex flex-col gap-6">
            <div class="w-16 h-16 bg-[#F0FDF4] border border-[#D1FAE5] rounded-full flex items-center justify-center mx-auto text-[#2E9F5B]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#111111] font-outfit">Đặt hàng thành công!</h1>
                <p class="text-xs text-[#666666] mt-2">Cảm ơn bạn đã tin dùng sản phẩm pin của TS Battery.</p>
            </div>

            <div class="bg-[#F7F7F7] border border-[#ECECEC] rounded p-4 text-left flex flex-col gap-2">
                <p class="text-xs text-[#666666]">Mã đơn hàng của bạn: <strong class="text-[#111111] font-semibold">{{ $placedOrderCode }}</strong></p>
                <p class="text-xs text-[#666666]">Tổng tiền thanh toán: <strong class="text-[#2E9F5B] font-semibold">{{ number_format($totalAmount, 0, ',', '.') }}đ</strong></p>
                <p class="text-xs text-[#666666]">Hình thức: <strong class="text-[#111111] font-semibold">{{ $payment_method === 'COD' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}</strong></p>
            </div>

            @if($payment_method === 'Bank')
                <!-- Thông tin chuyển khoản tối giản -->
                <div class="border border-[#2E9F5B]/30 bg-[#F0FDF4]/30 rounded p-5 text-left flex flex-col gap-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#2E9F5B]">Thông tin chuyển khoản</h3>
                    <div class="text-xs text-[#666666] flex flex-col gap-1">
                        <p>Ngân hàng: <strong class="text-[#111111] font-semibold">Vietcombank</strong></p>
                        <p>Số tài khoản: <strong class="text-[#111111] font-semibold">1234567890</strong></p>
                        <p>Chủ tài khoản: <strong class="text-[#111111] font-semibold">CÔNG TY CỔ PHẦN TS BATTERY</strong></p>
                        <p>Nội dung chuyển khoản: <strong class="text-[#2E9F5B] font-semibold">{{ $placedOrderCode }}</strong></p>
                    </div>
                    <p class="text-[10px] text-[#666666]">Lưu ý: Đơn hàng sẽ được xử lý ngay sau khi hệ thống ghi nhận khoản thanh toán của bạn.</p>
                </div>
            @endif

            <a href="/" class="inline-block bg-[#2E9F5B] text-white font-semibold text-xs uppercase tracking-wider py-3.5 px-8 rounded hover:bg-[#238247] transition duration-200">
                Quay lại trang chủ
            </a>
        </div>
    @else
        <!-- Giao diện nhập thông tin đặt hàng -->
        <h1 class="text-2xl font-bold tracking-tight text-[#111111] font-outfit uppercase mb-8 pb-4 border-b border-[#ECECEC]">Thanh toán đơn hàng</h1>

        <form wire:submit.prevent="placeOrder" class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Cột trái: Thông tin nhận hàng -->
            <div class="lg:col-span-7 bg-white border border-[#ECECEC] rounded-lg p-6 sm:p-8 flex flex-col gap-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#111111]">Thông tin giao hàng</h3>
                
                @if (session()->has('error'))
                    <div class="bg-red-50 text-red-700 text-xs p-3 rounded border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Họ tên -->
                <div class="flex flex-col gap-1.5">
                    <label for="customer_name" class="text-xs font-semibold text-[#111111]">Họ và tên <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="customer_name" 
                        wire:model="customer_name"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('customer_name') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition duration-150"
                        placeholder="Nhập đầy đủ họ tên người nhận"
                    />
                    @error('customer_name') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="flex flex-col gap-1.5">
                    <label for="customer_phone" class="text-xs font-semibold text-[#111111]">Số điện thoại <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="customer_phone" 
                        wire:model="customer_phone"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('customer_phone') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition duration-150"
                        placeholder="Số điện thoại nhận hàng"
                    />
                    @error('customer_phone') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Địa chỉ -->
                <div class="flex flex-col gap-1.5">
                    <label for="customer_address" class="text-xs font-semibold text-[#111111]">Địa chỉ giao hàng <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="customer_address" 
                        wire:model="customer_address"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('customer_address') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition duration-150"
                        placeholder="Địa chỉ số nhà, ngõ/ngách, xã/phường, quận/huyện..."
                    />
                    @error('customer_address') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                    <label for="customer_email" class="text-xs font-semibold text-[#111111]">Địa chỉ Email (Không bắt buộc)</label>
                    <input 
                        type="email" 
                        id="customer_email" 
                        wire:model="customer_email"
                        class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('customer_email') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition duration-150"
                        placeholder="Nhập email để nhận thông tin hành trình đơn hàng"
                    />
                    @error('customer_email') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Phương thức thanh toán -->
                <div>
                    <label class="text-xs font-semibold text-[#111111] mb-2 block">Phương thức thanh toán</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- COD option -->
                        <label class="border @if($payment_method === 'COD') border-[#2E9F5B] bg-[#F0FDF4]/30 @else border-[#ECECEC] @endif p-4 rounded flex items-center gap-3 cursor-pointer hover:bg-[#F7F7F7] transition duration-150">
                            <input type="radio" value="COD" wire:model.live="payment_method" class="text-[#2E9F5B] focus:ring-[#2E9F5B] border-[#ECECEC]">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-[#111111]">Giao hàng COD</span>
                                <span class="text-[10px] text-[#666666]">Thanh toán tiền mặt khi nhận hàng</span>
                            </div>
                        </label>
                        
                        <!-- Bank option -->
                        <label class="border @if($payment_method === 'Bank') border-[#2E9F5B] bg-[#F0FDF4]/30 @else border-[#ECECEC] @endif p-4 rounded flex items-center gap-3 cursor-pointer hover:bg-[#F7F7F7] transition duration-150">
                            <input type="radio" value="Bank" wire:model.live="payment_method" class="text-[#2E9F5B] focus:ring-[#2E9F5B] border-[#ECECEC]">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-[#111111]">Chuyển khoản</span>
                                <span class="text-[10px] text-[#666666]">Chuyển khoản ngân hàng trực tiếp</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Tóm tắt đơn hàng -->
            <div class="lg:col-span-5 flex flex-col gap-6 sticky top-24">
                <div class="bg-white border border-[#ECECEC] rounded-lg p-6 sm:p-8 flex flex-col gap-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#111111]">Tóm tắt đơn hàng</h3>
                    
                    <!-- Danh sách sản phẩm -->
                    <div class="flex flex-col gap-4 divide-y divide-[#ECECEC] max-h-72 overflow-y-auto pr-2">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-3 pt-4 first:pt-0">
                                <div class="w-12 h-12 bg-[#F7F7F7] border border-[#ECECEC] rounded flex-shrink-0 flex items-center justify-center p-1">
                                    <span class="text-[10px] font-bold text-[#666666] uppercase">TS.B</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-[#111111] truncate">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] text-[#666666]">Số lượng: {{ $item['quantity'] }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-[#111111]">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tính tiền -->
                    <div class="border-t border-[#ECECEC] pt-4 flex flex-col gap-3">
                        <div class="flex justify-between text-xs">
                            <span class="text-[#666666]">Tạm tính:</span>
                            <span class="font-semibold text-[#111111]">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-[#666666]">Phí vận chuyển:</span>
                            <span class="font-semibold text-[#2E9F5B]">Miễn phí</span>
                        </div>
                        <hr class="border-[#ECECEC]">
                        <div class="flex justify-between text-sm">
                            <span class="font-bold text-[#111111]">Tổng thanh toán:</span>
                            <span class="font-extrabold text-[#2E9F5B] text-base">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-[#2E9F5B] text-white py-3.5 rounded text-sm font-semibold uppercase tracking-wider hover:bg-[#238247] transition duration-200 focus:outline-none flex items-center justify-center gap-2"
                    >
                        <span>Xác nhận đặt hàng</span>
                        <!-- Loading spinner -->
                        <div wire:loading class="animate-spin h-4 w-4 text-white border-2 border-t-transparent rounded-full"></div>
                    </button>
                </div>
            </div>

        </form>
    @endif

</div>
