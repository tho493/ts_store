@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - TS Battery')

@section('content')
<div class="max-w-4xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-[#111111] font-outfit uppercase">Đơn hàng của tôi</h1>
        <p class="text-xs text-[#666666] mt-2 uppercase tracking-wider">Danh sách đơn hàng bạn đã đặt tại TS Battery</p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white border border-[#ECECEC] rounded-lg p-12 text-center shadow-sm">
            <svg class="w-12 h-12 mx-auto text-[#CCCCCC] mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
            </svg>
            <h3 class="text-sm font-semibold text-[#111111]">Bạn chưa có đơn hàng nào</h3>
            <p class="text-xs text-[#666666] mt-1">Hãy khám phá sản phẩm và mua sắm ngay hôm nay!</p>
            <a href="/" class="inline-block bg-[#111111] hover:bg-[#2E9F5B] text-white text-xs font-semibold uppercase tracking-widest px-6 py-3 rounded mt-6 transition-colors duration-300">
                Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="flex flex-col gap-6">
            @foreach($orders as $order)
                <div class="bg-white border border-[#ECECEC] rounded-lg shadow-sm overflow-hidden">
                    <!-- Order Header -->
                    <div class="bg-[#F7F7F7] border-b border-[#ECECEC] px-6 py-4 flex flex-wrap items-center justify-between gap-4 text-xs">
                        <div class="flex flex-wrap gap-x-6 gap-y-2">
                            <div>
                                <span class="text-[#666666] uppercase tracking-wider block font-semibold">Mã đơn hàng</span>
                                <span class="font-bold text-[#111111] font-outfit text-sm">{{ $order->order_code }}</span>
                            </div>
                            <div>
                                <span class="text-[#666666] uppercase tracking-wider block font-semibold">Ngày đặt</span>
                                <span class="text-[#111111] font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-[#666666] uppercase tracking-wider block font-semibold">Tổng cộng</span>
                                <span class="text-[#2E9F5B] font-bold text-sm">{{ number_format($order->total) }}đ</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <!-- Trạng thái đơn hàng -->
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'shipping' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xử lý',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipping' => 'Đang giao hàng',
                                    'completed' => 'Đã hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                ];
                                $payStatusLabels = [
                                    'pending' => 'Chưa thanh toán',
                                    'paid' => 'Đã thanh toán',
                                    'failed' => 'Thất bại',
                                    'refunded' => 'Đã hoàn tiền',
                                ];
                                $payStatusClasses = [
                                    'pending' => 'bg-gray-100 text-gray-700',
                                    'paid' => 'bg-emerald-100 text-emerald-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                    'refunded' => 'bg-yellow-100 text-yellow-800',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full border text-[10px] font-semibold uppercase tracking-wider {{ $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                            <span class="px-2 py-1 rounded text-[10px] font-semibold uppercase tracking-wider {{ $payStatusClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $payStatusLabels[$order->payment_status] ?? $order->payment_status }}
                            </span>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="divide-y divide-[#ECECEC] px-6">
                        @foreach($order->items as $item)
                            <div class="py-4 flex items-center justify-between gap-4 text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-[#F7F7F7] border border-[#ECECEC] rounded flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#A0A0A0]" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-[#111111] text-sm">
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-[#2E9F5B] transition-colors">
                                                    {{ $item->product->name }}
                                                </a>
                                            @else
                                                Sản phẩm đã bị xóa
                                            @endif
                                        </h4>
                                        <p class="text-[#666666] mt-0.5">Số lượng: <span class="font-semibold text-[#111111]">{{ $item->quantity }}</span></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-[#111111]">{{ number_format($item->price * $item->quantity) }}đ</span>
                                    <p class="text-[10px] text-[#666666] mt-0.5">{{ number_format($item->price) }}đ / sản phẩm</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Footer -->
                    <div class="bg-[#F7F7F7]/50 border-t border-[#ECECEC] px-6 py-4 flex flex-wrap justify-between items-center gap-4 text-xs">
                        <div class="text-[#666666]">
                            <span class="block"><strong>Người nhận:</strong> {{ $order->customer_name }} - {{ $order->customer_phone }}</span>
                            <span class="block mt-0.5"><strong>Địa chỉ:</strong> {{ $order->customer_address }}</span>
                        </div>
                        <div class="text-[#666666]">
                            <span><strong>Thanh toán:</strong> {{ $order->payment_method === 'COD' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
