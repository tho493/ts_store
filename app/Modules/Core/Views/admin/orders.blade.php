@extends('core::admin.layout')

@section('page_title', 'Quản lý đơn hàng')

@section('admin_content')
<div class="bg-white border border-[#ECECEC] rounded overflow-hidden">
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-[#F7F7F7] border-b border-[#ECECEC] uppercase tracking-wider text-[#666666] font-semibold">
                    <th class="px-6 py-4">Mã đơn / Khách hàng</th>
                    <th class="px-6 py-4">Sản phẩm đã đặt</th>
                    <th class="px-6 py-4">Tổng tiền</th>
                    <th class="px-6 py-4">Trạng thái thanh toán</th>
                    <th class="px-6 py-4">Trạng thái đơn hàng</th>
                    <th class="px-6 py-4 text-right">Cập nhật</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#ECECEC]">
                @if($orders->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-[#666666]">
                            Chưa có đơn hàng nào được tạo.
                        </td>
                    </tr>
                @else
                    @foreach($orders as $order)
                        <tr class="hover:bg-[#F7F7F7]/30 transition items-start">
                            <!-- Khách hàng -->
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-1">
                                    <span class="font-mono font-bold text-sm text-[#111111]">{{ $order->order_code }}</span>
                                    <span class="font-semibold text-[#111111]">{{ $order->customer_name }}</span>
                                    <span class="text-[#666666]">{{ $order->customer_phone }}</span>
                                    <span class="text-[#666666] max-w-[200px] whitespace-normal break-words">{{ $order->customer_address }}</span>
                                    <span class="text-[10px] text-[#666666]">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </td>
                            <!-- Sản phẩm -->
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-2">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between gap-4 border-b border-[#F7F7F7] pb-1 last:border-0 last:pb-0">
                                            <span class="text-[#111111] font-medium truncate max-w-[200px]" title="{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}">
                                                {{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}
                                            </span>
                                            <span class="text-[#666666] whitespace-nowrap">x{{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <!-- Tổng tiền -->
                            <td class="px-6 py-4 align-top font-bold text-[#2E9F5B]">
                                {{ number_format($order->total, 0, ',', '.') }}đ
                            </td>
                            
                            <!-- Form Cập nhật trạng thái -->
                            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                                @csrf
                                <!-- Trạng thái thanh toán -->
                                <td class="px-6 py-4 align-top">
                                    <select 
                                        name="payment_status" 
                                        class="bg-[#F7F7F7] border border-[#ECECEC] rounded px-2 py-1 focus:outline-none focus:border-[#2E9F5B]"
                                    >
                                        <option value="pending" @if($order->payment_status === 'pending') selected @endif>Chưa trả</option>
                                        <option value="paid" @if($order->payment_status === 'paid') selected @endif>Đã trả</option>
                                        <option value="failed" @if($order->payment_status === 'failed') selected @endif>Thất bại</option>
                                        <option value="refunded" @if($order->payment_status === 'refunded') selected @endif>Đã hoàn</option>
                                    </select>
                                </td>
                                <!-- Trạng thái đơn -->
                                <td class="px-6 py-4 align-top">
                                    <select 
                                        name="status" 
                                        class="bg-[#F7F7F7] border border-[#ECECEC] rounded px-2 py-1 focus:outline-none focus:border-[#2E9F5B]"
                                    >
                                        <option value="pending" @if($order->status === 'pending') selected @endif>Chờ xác nhận</option>
                                        <option value="confirmed" @if($order->status === 'confirmed') selected @endif>Đã xác nhận</option>
                                        <option value="shipping" @if($order->status === 'shipping') selected @endif>Đang giao</option>
                                        <option value="completed" @if($order->status === 'completed') selected @endif>Hoàn thành</option>
                                        <option value="cancelled" @if($order->status === 'cancelled') selected @endif>Đã hủy</option>
                                    </select>
                                </td>
                                <!-- Hành động -->
                                <td class="px-6 py-4 align-top text-right">
                                    <button type="submit" class="bg-[#111111] text-white px-3 py-1.5 rounded font-bold hover:bg-[#2E9F5B] transition">
                                        Cập nhật
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-6 border-t border-[#ECECEC]">
        {{ $orders->links() }}
    </div>

</div>
@endsection
