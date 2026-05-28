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
    specs: {{ json_encode($specList) }},
    thumbnailPreview: '',
    imagesPreviews: [],
    
    handleThumbnailChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.thumbnailPreview = URL.createObjectURL(file);
        } else {
            this.thumbnailPreview = '';
        }
    },
    
    handleImagesChange(e) {
        this.imagesPreviews = [];
        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            this.imagesPreviews.push(URL.createObjectURL(files[i]));
        }
    }
}">
    
    <div class="mb-6 flex justify-between items-center pb-4 border-b border-[#F7F7F7]">
        <h3 class="text-sm font-bold uppercase tracking-wider text-[#111111]">Chỉnh sửa sản phẩm pin</h3>
        <a href="{{ route('admin.products') }}" class="text-xs font-semibold text-[#666666] hover:text-[#2E9F5B]">
            &larr; Quay lại danh sách
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
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

        <!-- Ảnh đại diện sản phẩm -->
        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-semibold text-[#111111]">Ảnh đại diện sản phẩm</label>
            
            <div class="flex items-center gap-4 mb-2">
                <!-- Hiển thị ảnh hiện tại -->
                @if($product->thumbnail)
                    <div class="flex flex-col items-center">
                        <img src="{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail) }}" alt="Current image" class="w-24 h-24 object-contain border border-[#ECECEC] rounded p-1 bg-white">
                        <span class="text-[9px] text-[#666666] mt-1 font-medium">Ảnh hiện tại</span>
                    </div>
                @endif
                
                <!-- Icon mũi tên nếu có ảnh mới -->
                <div x-show="thumbnailPreview" class="text-[#666666] text-lg" style="display: none;">&rarr;</div>
                
                <!-- Hiển thị preview ảnh mới chọn -->
                <div x-show="thumbnailPreview" class="flex flex-col items-center" style="display: none;">
                    <img :src="thumbnailPreview" alt="New Preview" class="w-24 h-24 object-contain border border-[#2E9F5B] rounded p-1 bg-white">
                    <span class="text-[9px] text-[#2E9F5B] mt-1 font-bold">Ảnh mới chọn</span>
                </div>
            </div>

            <div class="relative border-2 border-dashed border-[#ECECEC] rounded-lg p-4 bg-[#F7F7F7] hover:border-[#2E9F5B] transition-colors flex flex-col items-center justify-center cursor-pointer"
                 @click="$refs.thumbnailInput.click()">
                
                <input 
                    type="file" 
                    x-ref="thumbnailInput"
                    id="thumbnail" 
                    name="thumbnail" 
                    accept="image/*"
                    class="hidden"
                    @change="handleThumbnailChange"
                />
                
                <div class="flex flex-col items-center py-2">
                    <svg class="w-8 h-8 text-[#666666] mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                    </svg>
                    <span class="text-xs font-semibold text-[#111111]">Nhấp để chọn ảnh thay thế</span>
                    <span class="text-[9px] text-[#666666] mt-0.5">JPEG, PNG, JPG, GIF, SVG (tối đa 2MB)</span>
                </div>
            </div>
            @error('thumbnail') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Album ảnh phụ sản phẩm -->
        <div class="flex flex-col gap-4 p-4 bg-[#F7F7F7] border border-[#ECECEC] rounded-lg">
            <div>
                <label class="text-xs font-semibold text-[#111111]">Album ảnh phụ hiện tại</label>
                @if($product->images->isEmpty())
                    <p class="text-[10px] text-[#666666] mt-1">Chưa có ảnh phụ.</p>
                @else
                    <div class="flex flex-wrap gap-4 mt-2">
                        @foreach($product->images as $img)
                            <div class="relative w-20 h-20 border border-[#ECECEC] rounded p-1.5 bg-white flex items-center justify-center group shadow-sm">
                                <img src="{{ asset('storage/' . $img->image) }}" alt="Sub image" class="w-full h-full object-contain">
                                
                                <!-- Nút xóa ảnh phụ (không dùng form lồng) -->
                                <button 
                                    type="button" 
                                    @click="if(confirm('Bạn có chắc chắn muốn xóa ảnh phụ này?')) { 
                                        let form = document.getElementById('delete-image-form'); 
                                        form.action = '{{ route('admin.products.images.delete', $img->id) }}'; 
                                        form.submit(); 
                                    }" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] hover:bg-red-700 cursor-pointer shadow transition focus:outline-none"
                                    title="Xóa ảnh phụ"
                                >
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="border-t border-[#ECECEC] pt-4">
                <label class="text-xs font-semibold text-[#111111]">Thêm ảnh phụ mới</label>
                <div class="border-2 border-dashed border-[#ECECEC] rounded-lg p-4 bg-white hover:border-[#2E9F5B] transition-colors flex flex-col items-center justify-center cursor-pointer mt-1.5 mb-2"
                     @click="$refs.imagesInput.click()">
                    
                    <input 
                        type="file" 
                        x-ref="imagesInput"
                        id="images" 
                        name="images[]" 
                        accept="image/*"
                        multiple
                        class="hidden"
                        @change="handleImagesChange"
                    />
                    
                    <div class="flex flex-col items-center py-1">
                        <svg class="w-7 h-7 text-[#666666] mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-xs font-medium text-[#111111]">Nhấp để tải lên ảnh phụ mới</span>
                    </div>
                </div>

                <!-- Previews ảnh phụ chuẩn bị tải lên -->
                <div x-show="imagesPreviews.length > 0" class="mt-3">
                    <span class="text-[10px] font-bold text-[#666666] uppercase block mb-2">Ảnh phụ chuẩn bị thêm (Tổng: <span x-text="imagesPreviews.length"></span>)</span>
                    <div class="flex flex-wrap gap-3">
                        <template x-for="(src, index) in imagesPreviews" :key="index">
                            <div class="relative w-16 h-16 border border-[#2E9F5B] rounded p-1 bg-white flex items-center justify-center">
                                <img :src="src" class="w-full h-full object-contain">
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            @error('images') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="flex flex-col gap-1.5">
            <label for="description" class="text-xs font-semibold text-[#111111]">Mô tả sản phẩm (Ngắn)</label>
            <textarea 
                id="description" 
                name="description" 
                rows="3"
                class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
            >{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Mô tả chi tiết (Bài viết giới thiệu sản phẩm) -->
        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-semibold text-[#111111]">Mô tả chi tiết (Bài viết giới thiệu sản phẩm)</label>
            <div class="bg-white border border-[#ECECEC] rounded">
                <div id="editor-container" style="height: 300px;" class="text-xs"></div>
            </div>
            <input type="hidden" id="content" name="content" value="{{ old('content', $product->content) }}">
            @error('content') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
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

<!-- Form xóa ảnh phụ ẩn để tránh lỗi lồng form -->
<form id="delete-image-form" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        const contentInput = document.getElementById('content');
        if (contentInput.value) {
            quill.root.innerHTML = contentInput.value;
        }

        quill.on('text-change', function() {
            contentInput.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        });
    });
</script>
@endsection
