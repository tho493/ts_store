@extends('core::admin.layout')

@section('page_title', 'Thêm sản phẩm mới')

@section('admin_content')
<div class="bg-white border border-[#ECECEC] rounded-lg p-6 sm:p-8 max-w-3xl" x-data="{ 
    specs: [
        { key: 'Thương hiệu', value: '' },
        { key: 'Dung lượng', value: '' },
        { key: 'Điện áp', value: '' },
        { key: 'Bảo hành', value: '12 tháng' }
    ],
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
        <h3 class="text-sm font-bold uppercase tracking-wider text-[#111111]">Thông tin sản phẩm pin mới</h3>
        <a href="{{ route('admin.products') }}" class="text-xs font-semibold text-[#666666] hover:text-[#2E9F5B]">
            &larr; Quay lại danh sách
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf

        <!-- Hàng 1: Tên & SKU -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-xs font-semibold text-[#111111]">Tên sản phẩm <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('name') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    placeholder="Ví dụ: Pin Laptop Dell Latitude E7440"
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
                    value="{{ old('sku') }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('sku') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    placeholder="Ví dụ: DELL-E7440"
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
                        <option value="{{ $cat->id }}" @if(old('category_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
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
                    value="{{ old('stock', 0) }}"
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
                    value="{{ old('price') }}"
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
                    value="{{ old('sale_price') }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('sale_price') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    min="0"
                />
                @error('sale_price') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Ảnh đại diện sản phẩm -->
        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-semibold text-[#111111]">Ảnh đại diện sản phẩm <span class="text-red-500">*</span></label>
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
                    required
                />
                
                <!-- Khi chưa chọn ảnh -->
                <div x-show="!thumbnailPreview" class="flex flex-col items-center py-4">
                    <svg class="w-10 h-10 text-[#666666] mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-medium text-[#111111]">Nhấp để tải lên ảnh đại diện</span>
                    <span class="text-[10px] text-[#666666] mt-1">Định dạng JPEG, PNG, JPG, GIF, SVG (tối đa 2MB)</span>
                </div>

                <!-- Khi đã chọn ảnh -->
                <div x-show="thumbnailPreview" class="flex flex-col items-center gap-2">
                    <img :src="thumbnailPreview" alt="Thumbnail Preview" class="w-32 h-32 object-contain border border-[#ECECEC] rounded p-1 bg-white">
                    <span class="text-[10px] text-[#2E9F5B] font-semibold">Ảnh đã được chọn - Nhấp để đổi</span>
                </div>
            </div>
            @error('thumbnail') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Album ảnh phụ sản phẩm -->
        <div class="flex flex-col gap-1.5 p-4 bg-[#F7F7F7] border border-[#ECECEC] rounded-lg">
            <label class="text-xs font-semibold text-[#111111]">Album ảnh phụ sản phẩm (Chọn nhiều ảnh)</label>
            <div class="border-2 border-dashed border-[#ECECEC] rounded-lg p-4 bg-white hover:border-[#2E9F5B] transition-colors flex flex-col items-center justify-center cursor-pointer mb-2"
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
                
                <div class="flex flex-col items-center py-2">
                    <svg class="w-8 h-8 text-[#666666] mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                    </svg>
                    <span class="text-xs font-medium text-[#111111]">Nhấp để chọn thêm ảnh phụ</span>
                </div>
            </div>

            <!-- Previews ảnh phụ chuẩn bị tải lên -->
            <div x-show="imagesPreviews.length > 0" class="mt-2">
                <span class="text-[10px] font-bold text-[#666666] uppercase block mb-2">Ảnh phụ chuẩn bị tải lên (Tổng: <span x-text="imagesPreviews.length"></span>)</span>
                <div class="flex flex-wrap gap-3">
                    <template x-for="(src, index) in imagesPreviews" :key="index">
                        <div class="relative w-16 h-16 border border-[#ECECEC] rounded p-1 bg-white flex items-center justify-center">
                            <img :src="src" class="w-full h-full object-contain">
                        </div>
                    </template>
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
                placeholder="Nhập thông tin giới thiệu ngắn gọn về sản phẩm pin..."
            >{{ old('description') }}</textarea>
        </div>

        <!-- Mô tả chi tiết (giới thiệu sản phẩm) -->
        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-semibold text-[#111111]">Mô tả chi tiết (Bài viết giới thiệu sản phẩm)</label>
            <div class="bg-white border border-[#ECECEC] rounded">
                <div id="editor-container" style="height: 300px;" class="text-xs"></div>
            </div>
            <input type="hidden" id="content" name="content" value="{{ old('content') }}">
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
                            placeholder="Tên thông số (ví dụ: Điện áp)"
                            class="flex-1 bg-white text-xs text-[#111111] border border-[#ECECEC] rounded px-3 py-1.5 focus:outline-none focus:border-[#2E9F5B]"
                            required
                        />
                        <input 
                            type="text" 
                            name="spec_values[]" 
                            x-model="spec.value"
                            placeholder="Giá trị (ví dụ: 12.8 V)"
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
                checked
                class="rounded text-[#2E9F5B] focus:ring-[#2E9F5B] border-[#ECECEC]"
            />
            <label for="status" class="text-xs font-semibold text-[#111111]">Cho phép hiển thị bán ngay lập tức trên website</label>
        </div>

        <!-- Nút submit -->
        <button type="submit" class="bg-[#2E9F5B] text-white py-3 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#238247] transition">
            Lưu sản phẩm mới
        </button>
    </form>

</div>

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
