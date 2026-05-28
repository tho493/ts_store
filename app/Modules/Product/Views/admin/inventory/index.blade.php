@extends('core::admin.layout')

@section('page_title', 'Quản lý tồn kho')

@section('admin_content')
<div class="flex flex-col gap-6">

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.inventory') }}" class="bg-white border border-[#ECECEC] rounded p-4 flex flex-wrap gap-3 items-end">
        <div class="flex flex-col gap-1 min-w-[160px]">
            <label class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Sản phẩm</label>
            <select name="product_id" class="bg-[#F7F7F7] border border-[#ECECEC] text-xs px-3 py-2 rounded focus:outline-none focus:border-[#2E9F5B]">
                <option value="">Tất cả sản phẩm</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>
                        [{{ $prod->sku }}] {{ $prod->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Loại</label>
            <select name="type" class="bg-[#F7F7F7] border border-[#ECECEC] text-xs px-3 py-2 rounded focus:outline-none focus:border-[#2E9F5B]">
                <option value="">Tất cả</option>
                <option value="in"         {{ $type === 'in'         ? 'selected' : '' }}>Nhập kho</option>
                <option value="out"        {{ $type === 'out'        ? 'selected' : '' }}>Xuất kho</option>
                <option value="adjustment" {{ $type === 'adjustment' ? 'selected' : '' }}>Điều chỉnh</option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Từ ngày</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="bg-[#F7F7F7] border border-[#ECECEC] text-xs px-3 py-2 rounded focus:outline-none focus:border-[#2E9F5B]">
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Đến ngày</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="bg-[#F7F7F7] border border-[#ECECEC] text-xs px-3 py-2 rounded focus:outline-none focus:border-[#2E9F5B]">
        </div>
        <button type="submit" class="bg-[#2E9F5B] text-white text-xs font-bold uppercase tracking-wider px-4 py-2 rounded hover:bg-[#238247] transition">
            Lọc
        </button>
        @if($productId || $type || $dateFrom || $dateTo)
            <a href="{{ route('admin.inventory') }}" class="text-xs text-[#666666] hover:text-[#111111] py-2">Xóa lọc</a>
        @endif
    </form>

    <!-- Table -->
    <div class="bg-white border border-[#ECECEC] rounded overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F7F7F7] border-b border-[#ECECEC] uppercase tracking-wider text-[#666666] font-semibold">
                        <th class="px-4 py-3">Thời gian</th>
                        <th class="px-4 py-3">Sản phẩm</th>
                        <th class="px-4 py-3">Loại</th>
                        <th class="px-4 py-3">Lý do</th>
                        <th class="px-4 py-3 text-center">SL thay đổi</th>
                        <th class="px-4 py-3 text-center">Tồn trước</th>
                        <th class="px-4 py-3 text-center">Tồn sau</th>
                        <th class="px-4 py-3">Tham chiếu</th>
                        <th class="px-4 py-3">Người thực hiện</th>
                        <th class="px-4 py-3">Ghi chú</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ECECEC]">
                    @forelse($movements as $mv)
                        <tr class="hover:bg-[#F7F7F7]/50 transition">
                            <td class="px-4 py-3 text-[#666666] whitespace-nowrap">
                                {{ $mv->created_at->format('d/m H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.inventory.product', $mv->product_id) }}" class="font-bold text-[#111111] hover:text-[#2E9F5B]">
                                    {{ $mv->product->name ?? '—' }}
                                </a>
                                <div class="text-[10px] text-[#666666]">{{ $mv->product->sku ?? '' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $typeClass = match($mv->type) {
                                        'in'         => 'bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5]',
                                        'out'        => 'bg-red-50 text-red-700 border border-red-200',
                                        'adjustment' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    };
                                @endphp
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $typeClass }}">
                                    {{ $mv->type_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#666666]">{{ $mv->reason_label }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono {{ $mv->type === 'out' ? 'text-red-600' : 'text-[#2E9F5B]' }}">
                                {{ $mv->signed_quantity }}
                            </td>
                            <td class="px-4 py-3 text-center text-[#666666]">{{ $mv->quantity_before }}</td>
                            <td class="px-4 py-3 text-center font-bold text-[#111111]">{{ $mv->quantity_after }}</td>
                            <td class="px-4 py-3 text-[#666666]">
                                @if($mv->reference_id)
                                    <span class="text-[10px] font-mono bg-[#F7F7F7] border border-[#ECECEC] px-1.5 py-0.5 rounded">
                                        #{{ $mv->reference_id }}
                                    </span>
                                @else
                                    <span class="text-[#ECECEC]">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-[#666666]">
                                {{ $mv->user?->name ?? 'Hệ thống' }}
                            </td>
                            <td class="px-4 py-3 text-[#666666] max-w-[160px] truncate" title="{{ $mv->note }}">
                                {{ $mv->note ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-16 text-center text-[#666666] text-xs">
                                Chưa có biến động tồn kho nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movements->hasPages())
            <div class="p-4 border-t border-[#ECECEC]">
                {{ $movements->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
