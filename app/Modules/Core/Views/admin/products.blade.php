@extends('core::admin.layout')

@section('page_title', 'Quản lý sản phẩm')

@section('admin_content')
<div class="flex flex-col gap-6">
    
    <!-- Action Bar -->
    <div class="flex flex-wrap justify-between items-center gap-3">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#666666]">Danh sách pin</h3>
        <a href="{{ route('admin.products.create') }}" class="bg-[#2E9F5B] text-white px-4 py-2 rounded text-xs font-bold uppercase tracking-wider hover:bg-[#238247] transition">
            + Thêm sản phẩm mới
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-[#ECECEC] rounded overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F7F7F7] border-b border-[#ECECEC] uppercase tracking-wider text-[#666666] font-semibold">
                        <th class="px-4 py-3">Sản phẩm</th>
                        <th class="px-4 py-3 hidden sm:table-cell">Mã SKU</th>
                        <th class="px-4 py-3 hidden md:table-cell">Danh mục</th>
                        <th class="px-4 py-3">Giá bán</th>
                        <th class="px-4 py-3 text-center">Tồn kho</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ECECEC]">
                    @foreach($products as $prod)
                        <tr class="hover:bg-[#F7F7F7]/30 transition">
                            <!-- Tên sản phẩm -->
                            <td class="px-4 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#111111]">{{ $prod->name }}</span>
                                    <span class="text-[10px] text-[#666666] mt-0.5">
                                        <span class="{{ $prod->status ? 'text-[#2E9F5B]' : 'text-red-500' }}">{{ $prod->status ? '● Đang bán' : '● Ẩn' }}</span>
                                    </span>
                                </div>
                            </td>
                            <!-- SKU -->
                            <td class="px-4 py-4 font-mono font-medium text-[#111111] hidden sm:table-cell">
                                {{ $prod->sku }}
                            </td>
                            <!-- Category -->
                            <td class="px-4 py-4 text-[#666666] hidden md:table-cell">
                                {{ $prod->category->name ?? '—' }}
                            </td>
                            <!-- Giá -->
                            <td class="px-4 py-4">
                                <div class="flex flex-col">
                                    @if($prod->sale_price)
                                        <span class="font-bold text-[#2E9F5B]">{{ number_format($prod->sale_price, 0, ',', '.') }}đ</span>
                                        <span class="text-[10px] text-[#666666] line-through">{{ number_format($prod->price, 0, ',', '.') }}đ</span>
                                    @else
                                        <span class="font-bold text-[#111111]">{{ number_format($prod->price, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>
                            </td>
                            <!-- Tồn kho (read-only badge) -->
                            <td class="px-4 py-4 text-center">
                                @if($prod->stock <= 0)
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-[10px] font-bold px-2 py-0.5 rounded">Hết hàng</span>
                                @elseif($prod->stock < 10)
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-[10px] font-bold px-2 py-0.5 rounded">{{ $prod->stock }} (Thấp)</span>
                                @else
                                    <span class="bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5] text-[10px] font-bold px-2 py-0.5 rounded">{{ $prod->stock }}</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 sm:gap-3">
                                    <!-- Nút Kho -->
                                    <a href="{{ route('admin.inventory.product', $prod->id) }}" class="text-blue-600 hover:underline font-bold whitespace-nowrap">
                                        Kho
                                    </a>
                                    <!-- Nút Sửa -->
                                    <a href="{{ route('admin.products.edit', $prod->id) }}" class="text-[#2E9F5B] hover:underline font-bold">
                                        Sửa
                                    </a>
                                    <!-- Nút Xóa -->
                                    <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline font-bold">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-[#ECECEC]">
            {{ $products->links() }}
        </div>
    </div>
    
</div>
@endsection
