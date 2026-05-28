@extends('core::admin.layout')

@section('page_title', 'Tồn kho: ' . $product->name)

@section('admin_content')
<div class="flex flex-col gap-6">

    <!-- Breadcrumb & Actions -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2 text-xs text-[#666666]">
            <a href="{{ route('admin.inventory') }}" class="hover:text-[#2E9F5B]">Quản lý kho</a>
            <span>/</span>
            <span class="text-[#111111] font-semibold">{{ $product->name }}</span>
        </div>
        <a href="{{ route('admin.inventory.adjust', $product->id) }}" class="bg-[#2E9F5B] text-white px-4 py-2 rounded text-xs font-bold uppercase tracking-wider hover:bg-[#238247] transition">
            + Điều chỉnh tồn kho
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-3 sm:gap-6">
        <div class="bg-white border border-[#ECECEC] rounded p-4 sm:p-6 flex flex-col gap-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Tồn hiện tại</span>
            @php
                $stockClass = $product->stock > 10 ? 'text-[#2E9F5B]' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600');
            @endphp
            <span class="text-3xl font-extrabold font-outfit {{ $stockClass }}">{{ $product->stock }}</span>
        </div>
        <div class="bg-white border border-[#ECECEC] rounded p-4 sm:p-6 flex flex-col gap-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Tổng đã nhập</span>
            <span class="text-3xl font-extrabold font-outfit text-[#2E9F5B]">+{{ $totalIn }}</span>
        </div>
        <div class="bg-white border border-[#ECECEC] rounded p-4 sm:p-6 flex flex-col gap-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#666666]">Tổng đã xuất</span>
            <span class="text-3xl font-extrabold font-outfit text-red-600">-{{ $totalOut }}</span>
        </div>
    </div>

    <!-- Product Info Card -->
    <div class="bg-white border border-[#ECECEC] rounded p-4 flex flex-wrap gap-6 text-xs text-[#666666]">
        <div><span class="font-bold text-[#111111]">SKU:</span> {{ $product->sku }}</div>
        <div><span class="font-bold text-[#111111]">Danh mục:</span> {{ $product->category->name ?? '—' }}</div>
        <div><span class="font-bold text-[#111111]">Giá bán:</span> {{ number_format($product->final_price, 0, ',', '.') }}đ</div>
        <div>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-[#2E9F5B] hover:underline font-semibold">
                → Chỉnh sửa sản phẩm
            </a>
        </div>
    </div>

    <!-- Movement History -->
    <div class="bg-white border border-[#ECECEC] rounded overflow-hidden shadow-sm">
        <div class="px-4 sm:px-6 py-4 border-b border-[#ECECEC]">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111]">Lịch sử biến động tồn kho</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F7F7F7] border-b border-[#ECECEC] uppercase tracking-wider text-[#666666] font-semibold">
                        <th class="px-4 py-3">Thời gian</th>
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
                                {{ $mv->created_at->format('d/m/Y H:i') }}
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
                            <td class="px-4 py-3 text-center font-bold font-mono text-base {{ $mv->type === 'out' ? 'text-red-600' : 'text-[#2E9F5B]' }}">
                                {{ $mv->signed_quantity }}
                            </td>
                            <td class="px-4 py-3 text-center text-[#666666]">{{ $mv->quantity_before }}</td>
                            <td class="px-4 py-3 text-center font-bold text-[#111111]">{{ $mv->quantity_after }}</td>
                            <td class="px-4 py-3 text-[#666666]">
                                @if($mv->reference_id)
                                    <span class="font-mono bg-[#F7F7F7] border border-[#ECECEC] px-1.5 py-0.5 rounded">#{{ $mv->reference_id }}</span>
                                @else —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-[#666666]">{{ $mv->user?->name ?? 'Hệ thống' }}</td>
                            <td class="px-4 py-3 text-[#666666] max-w-[180px] truncate" title="{{ $mv->note }}">
                                {{ $mv->note ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center text-[#666666]">
                                Chưa có biến động nào cho sản phẩm này.
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
