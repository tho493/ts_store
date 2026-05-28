@extends('core::admin.layout')

@section('page_title', 'Chỉnh sửa sản phẩm')

@section('admin_content')
@php
    // Chuyển đổi mảng key-value của specifications sang dạng array of objects cho AlpineJS
    $specList = [];
    if (!empty($product->specifications) && is_array($product->specifications)) {
        foreach ($product->specifications as $key => $value) {
            $specList[] = ['key' => $key, 'value' => $value];
        }
    } else {
        $specList = [
            ['key' => 'Thương hiệu', 'value' => ''],
            ['key' => 'Dung lượng', 'value' => ''],
            ['key' => 'Điện áp', 'value' => '']
        ];
    }
@endphp

<div class="bg-white border border-[#ECECEC] rounded-lg p-6 sm:p-8 max-w-3xl" x-data="{ 
    specs: {{ json_encode($specList) }} 
}">
    
    <div class="mb-6 flex justify-between items-center pb-4 border-b border-[#F7F7F7]">
        <h3 class="text-sm font-bold uppercase tracking-wider text-[#111111]">Chỉnh sửa sản phẩm pin</h3>
        <a href="{{ route('admin.products') }}" class="text-xs font-semibold text-[#666666] hover:text-[#2E9F5B]">
            &larr; Quay lại danh sách
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="flex flex-col gap-6">
        @csrf

        <!-- Hàng 1: Tên & SKU -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-xs font-semibold text-[#111111]">Tên sản phẩm <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $product->name) }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('name') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    required
                />
                @error('name') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1.5">
                <label for="sku" class="text-xs font-semibold text-[#111111]">Mã SKU <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="sku" 
                    name="sku" 
                    value="{{ old('sku', $product->sku) }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('sku') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    required
                />
                @error('sku') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Hàng 2: Danh mục & Tồn kho -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1.5">
                <label for="category_id" class="text-xs font-semibold text-[#111111]">Danh mục sản phẩm <span class="text-red-500">*</span></label>
                <select 
                    id="category_id" 
                    name="category_id" 
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('category_id') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    required
                >
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @if(old('category_id', $product->category_id) == $cat->id) selected @endif>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1.5">
                <label for="stock" class="text-xs font-semibold text-[#111111]">Số lượng tồn kho <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    id="stock" 
                    name="stock" 
                    value="{{ old('stock', $product->stock) }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('stock') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    min="0"
                    required
                />
                @error('stock') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Hàng 3: Giá bán & Giá khuyến mãi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1.5">
                <label for="price" class="text-xs font-semibold text-[#111111]">Giá bán (đ) <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="{{ old('price', (int)$product->price) }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('price') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    min="0"
                    required
                />
                @error('price') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1.5">
                <label for="sale_price" class="text-xs font-semibold text-[#111111]">Giá khuyến mãi (nếu có)</label>
                <input 
                    type="number" 
                    id="sale_price" 
                    name="sale_price" 
                    value="{{ old('sale_price', $product->sale_price ? (int)$product->sale_price : '') }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('sale_price') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    min="0"
                />
                @error('sale_price') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="flex flex-col gap-1.5">
            <label for="description" class="text-xs font-semibold text-[#111111]">Mô tả sản phẩm</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
            >{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- THÔNG SỐ KỸ THUẬT ĐỘNG (Dynamic specifications - AlpineJS) -->
        <div class="flex flex-col gap-3 p-4 bg-[#F7F7F7] border border-[#ECECEC] rounded">
            <div class="flex justify-between items-center pb-2 border-b border-[#ECECEC]">
                <span class="text-xs font-bold text-[#111111]">Thông số kỹ thuật</span>
                <button 
                    type="button" 
                    @click="specs.push({ key: '', value: '' })"
                    class="text-[#2E9F5B] hover:underline text-[10px] font-bold uppercase tracking-wider"
                >
                    + Thêm dòng mới
                </button>
            </div>
            
            <div class="flex flex-col gap-3">
                <template x-for="(spec, index) in specs" :key="index">
                    <div class="flex gap-4 items-center">
                        <input 
                            type="text" 
                            name="spec_keys[]" 
                            x-model="spec.key"
                            placeholder="Tên thông số"
                            class="flex-1 bg-white text-xs text-[#111111] border border-[#ECECEC] rounded px-3 py-1.5 focus:outline-none focus:border-[#2E9F5B]"
                            required
                        />
                        <input 
                            type="text" 
                            name="spec_values[]" 
                            x-model="spec.value"
                            placeholder="Giá trị"
                            class="flex-1 bg-white text-xs text-[#111111] border border-[#ECECEC] rounded px-3 py-1.5 focus:outline-none focus:border-[#2E9F5B]"
                            required
                        />
                        <button 
                            type="button" 
                            @click="specs.splice(index, 1)"
                            class="text-red-500 hover:text-red-700 text-xs px-2"
                        >
                            Xóa
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Trạng thái bán -->
        <div class="flex items-center gap-3">
            <input 
                type="checkbox" 
                id="status" 
                name="status" 
                value="1" 
                @if($product->status) checked @endif
                class="rounded text-[#2E9F5B] focus:ring-[#2E9F5B] border-[#ECECEC]"
            />
            <label for="status" class="text-xs font-semibold text-[#111111]">Cho phép hiển thị bán trên website</label>
        </div>

        <!-- Nút submit -->
        <button type="submit" class="bg-[#2E9F5B] text-white py-3 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#238247] transition">
            Cập nhật sản phẩm
        </button>
    </form>

</div>
@endsection
