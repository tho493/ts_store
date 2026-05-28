@extends('core::admin.layout')

@section('page_title', 'Thêm tài khoản mới')

@section('admin_content')
<div class="max-w-xl bg-white border border-[#ECECEC] rounded-lg shadow-sm p-8">
    <div class="mb-6">
        <h3 class="text-sm font-bold text-[#111111] font-outfit uppercase">Tạo tài khoản</h3>
        <p class="text-xs text-[#666666] mt-1 font-medium">Nhập thông tin chi tiết để cấp tài khoản mới</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="flex flex-col gap-1.5">
            <label for="name" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Tên đăng nhập (Username)</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Ví dụ: admin_pin" required autofocus>
            @error('name')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="email" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Địa chỉ Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Ví dụ: example@tsbattery.com" required>
            @error('email')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="password" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Mật khẩu</label>
            <input type="password" id="password" name="password" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)" required>
            @error('password')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-1.5">
                <label for="role" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Vai trò</label>
                <select id="role" name="role" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] focus:outline-none focus:border-[#2E9F5B]">
                    <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                </select>
                @error('role')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="status" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Trạng thái</label>
                <select id="status" name="status" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] focus:outline-none focus:border-[#2E9F5B]">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Khóa tài khoản</option>
                </select>
                @error('status')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex gap-3 mt-4 border-t border-[#ECECEC] pt-6 justify-end">
            <a href="{{ route('admin.users') }}" class="border border-[#ECECEC] hover:bg-[#F7F7F7] text-[#666666] text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded transition">
                Hủy bỏ
            </a>
            <button type="submit" class="bg-[#111111] hover:bg-[#2E9F5B] text-white text-xs font-semibold uppercase tracking-widest px-6 py-2.5 rounded transition cursor-pointer">
                Lưu tài khoản
            </button>
        </div>
    </form>
</div>
@endsection
