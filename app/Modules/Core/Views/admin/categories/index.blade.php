@extends('core::admin.layout')

@section('page_title', 'Quản lý danh mục')

@section('admin_content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Cột trái: Danh sách danh mục (7/12) -->
    <div class="lg:col-span-7 bg-white border border-[#ECECEC] rounded overflow-hidden">
        <div class="p-6 border-b border-[#ECECEC]">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111]">Danh sách danh mục hiện tại</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F7F7F7] border-b border-[#ECECEC] uppercase tracking-wider text-[#666666] font-semibold">
                        <th class="px-6 py-4">Tên danh mục</th>
                        <th class="px-6 py-4">Đường dẫn (Slug)</th>
                        <th class="px-6 py-4">Số lượng sản phẩm</th>
                        <th class="px-6 py-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ECECEC]">
                    @foreach($categories as $cat)
                        <tr class="hover:bg-[#F7F7F7]/30 transition">
                            <td class="px-6 py-4 font-bold text-[#111111]">
                                {{ $cat->name }}
                            </td>
                            <td class="px-6 py-4 font-mono text-[#666666]">
                                {{ $cat->slug }}
                            </td>
                            <td class="px-6 py-4 font-medium text-[#111111]">
                                <span class="bg-[#F7F7F7] border border-[#ECECEC] px-2 py-0.5 rounded">
                                    {{ $cat->products->count() }} sản phẩm
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline font-bold">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cột phải: Form thêm danh mục mới (5/12) -->
    <div class="lg:col-span-5 bg-white border border-[#ECECEC] rounded p-6 flex flex-col gap-6">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] pb-2 border-b border-[#F7F7F7]">Thêm danh mục mới</h3>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-xs font-semibold text-[#111111]">Tên danh mục <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    placeholder="Ví dụ: Pin Thiết Bị Y Tế"
                    required
                />
            </div>

            <button type="submit" class="bg-[#2E9F5B] text-white py-2.5 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#238247] transition">
                Tạo danh mục
            </button>
        </form>
    </div>

</div>
@endsection
