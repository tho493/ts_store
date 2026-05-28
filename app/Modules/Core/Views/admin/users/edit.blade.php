@extends('core::admin.layout')

@section('page_title', 'Chỉnh sửa tài khoản')

@section('admin_content')
<div class="max-w-xl bg-white border border-[#ECECEC] rounded-lg shadow-sm p-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h3 class="text-sm font-bold text-[#111111] font-outfit uppercase">Cập nhật tài khoản</h3>
            <p class="text-xs text-[#666666] mt-1 font-medium">Chỉnh sửa thông tin tài khoản #{{ $user->id }} ({{ $user->name }})</p>
        </div>
        @if($user->id === Auth::id())
            <span class="bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5] px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">
                Tài khoản của bạn
            </span>
        @endif
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="flex flex-col gap-1.5">
            <label for="name" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Tên đăng nhập (Username)</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" required>
            @error('name')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="email" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Địa chỉ Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" required>
            @error('email')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="password" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Mật khẩu mới (Để trống nếu không muốn đổi)</label>
            <input type="password" id="password" name="password" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)">
            @error('password')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-1.5">
                <label for="role" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Vai trò</label>
                @if($user->id === Auth::id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <select id="role_disabled" disabled class="w-full bg-[#ECECEC] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#666666] cursor-not-allowed">
                        <option value="admin" selected>Quản trị viên (Admin) - Không được tự sửa</option>
                    </select>
                @else
                    <select id="role" name="role" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] focus:outline-none focus:border-[#2E9F5B]">
                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                @endif
                @error('role')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="status" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Trạng thái</label>
                @if($user->id === Auth::id())
                    <input type="hidden" name="status" value="{{ $user->status }}">
                    <select id="status_disabled" disabled class="w-full bg-[#ECECEC] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#666666] cursor-not-allowed">
                        <option value="active" selected>Hoạt động - Không được tự sửa</option>
                    </select>
                @else
                    <select id="status" name="status" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2 text-xs text-[#111111] focus:outline-none focus:border-[#2E9F5B]">
                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Khóa tài khoản</option>
                    </select>
                @endif
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
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection
