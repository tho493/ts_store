@extends('core::admin.layout')

@section('page_title', 'Điều chỉnh tồn kho')

@section('admin_content')
<div class="flex flex-col gap-6 max-w-xl">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-[#666666]">
        <a href="{{ route('admin.inventory') }}" class="hover:text-[#2E9F5B]">Quản lý kho</a>
        <span>/</span>
        <a href="{{ route('admin.inventory.product', $product->id) }}" class="hover:text-[#2E9F5B]">{{ $product->name }}</a>
        <span>/</span>
        <span class="text-[#111111] font-semibold">Điều chỉnh tồn kho</span>
    </div>

    <!-- Product Info -->
    <div class="bg-white border border-[#ECECEC] rounded p-4 flex flex-wrap gap-6 text-xs">
        <div>
            <span class="text-[#666666]">Sản phẩm: </span>
            <span class="font-bold text-[#111111]">{{ $product->name }}</span>
        </div>
        <div>
            <span class="text-[#666666]">SKU: </span>
            <span class="font-mono font-bold text-[#111111]">{{ $product->sku }}</span>
        </div>
        <div>
            <span class="text-[#666666]">Tồn kho hiện tại: </span>
            @php $stockClass = $product->stock > 10 ? 'text-[#2E9F5B]' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600'); @endphp
            <span class="font-bold text-xl {{ $stockClass }}">{{ $product->stock }}</span>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white border border-[#ECECEC] rounded p-6">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] mb-6 pb-3 border-b border-[#F7F7F7]">
            Phiếu điều chỉnh tồn kho
        </h3>

        <form action="{{ route('admin.inventory.adjust.store', $product->id) }}" method="POST" class="flex flex-col gap-5">
            @csrf

            <!-- Loại biến động -->
            <div class="flex flex-col gap-2" x-data="{ adjustType: '{{ old('type', 'in') }}' }">
                <label class="text-xs font-semibold text-[#111111]">Loại biến động <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="in" x-model="adjustType" class="sr-only peer">
                        <div class="text-center text-xs font-semibold py-3 rounded border-2 transition peer-checked:border-[#2E9F5B] peer-checked:bg-[#F0FDF4] peer-checked:text-[#2E9F5B] border-[#ECECEC] text-[#666666] hover:border-[#2E9F5B]">
                            ↑ Nhập kho
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="out" x-model="adjustType" class="sr-only peer">
                        <div class="text-center text-xs font-semibold py-3 rounded border-2 transition peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-600 border-[#ECECEC] text-[#666666] hover:border-red-400">
                            ↓ Xuất kho
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="adjustment" x-model="adjustType" class="sr-only peer">
                        <div class="text-center text-xs font-semibold py-3 rounded border-2 transition peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 border-[#ECECEC] text-[#666666] hover:border-blue-400">
                            ⟳ Kiểm kê
                        </div>
                    </label>
                </div>
                @error('type')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <!-- Lý do (chỉ hiện khi không phải adjustment) -->
                <div x-show="adjustType !== 'adjustment'" class="flex flex-col gap-1.5 mt-1">
                    <label class="text-xs font-semibold text-[#111111]">Lý do <span class="text-red-500">*</span></label>
                    <select name="reason" class="bg-[#F7F7F7] border border-[#ECECEC] text-xs px-3 py-2.5 rounded focus:outline-none focus:border-[#2E9F5B] transition">
                        <template x-if="adjustType === 'in'">
                            <optgroup label="Nhập kho">
                                <option value="purchase" {{ old('reason') === 'purchase' ? 'selected' : '' }}>Nhập hàng mới từ nhà cung cấp</option>
                                <option value="return"   {{ old('reason') === 'return'   ? 'selected' : '' }}>Khách trả hàng</option>
                            </optgroup>
                        </template>
                        <template x-if="adjustType === 'out'">
                            <optgroup label="Xuất kho">
                                <option value="damage"            {{ old('reason') === 'damage'            ? 'selected' : '' }}>Hàng hỏng / Mất</option>
                                <option value="manual_adjustment" {{ old('reason') === 'manual_adjustment' ? 'selected' : '' }}>Điều chỉnh thủ công</option>
                            </optgroup>
                        </template>
                    </select>
                    <!-- Hidden reason for adjustment -->
                    <input type="hidden" name="reason" value="manual_adjustment" x-show="adjustType === 'adjustment'">
                    @error('reason')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Số lượng -->
            <div class="flex flex-col gap-1.5" x-data="{}">
                <label for="quantity" class="text-xs font-semibold text-[#111111]">
                    Số lượng
                    <span class="text-[#666666] font-normal ml-1" x-text="adjustType === 'adjustment' ? '(Số tồn kho thực tế sau kiểm kê)' : '(Số lượng biến động)'"></span>
                    <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="{{ old('quantity', 1) }}"
                    min="1"
                    class="bg-[#F7F7F7] border border-[#ECECEC] text-sm font-bold px-4 py-2.5 rounded focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition w-full max-w-[160px]"
                />
                @error('quantity')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ghi chú -->
            <div class="flex flex-col gap-1.5">
                <label for="note" class="text-xs font-semibold text-[#111111]">Ghi chú <span class="text-[#666666] font-normal">(tuỳ chọn)</span></label>
                <textarea
                    id="note"
                    name="note"
                    rows="2"
                    placeholder="VD: Nhập hàng từ nhà cung cấp ABC, lô hàng ngày 28/05..."
                    class="bg-[#F7F7F7] border border-[#ECECEC] text-xs px-4 py-2.5 rounded focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition resize-none"
                >{{ old('note') }}</textarea>
                @error('note')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4 pt-2 border-t border-[#F7F7F7]">
                <button type="submit" class="bg-[#2E9F5B] text-white text-xs font-bold uppercase tracking-wider px-6 py-2.5 rounded hover:bg-[#238247] transition cursor-pointer">
                    Lưu điều chỉnh
                </button>
                <a href="{{ route('admin.inventory.product', $product->id) }}" class="text-xs text-[#666666] hover:text-[#111111]">
                    Hủy
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
