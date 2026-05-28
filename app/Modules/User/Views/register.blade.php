@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - TS Battery')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="bg-white border border-[#ECECEC] p-8 rounded-lg shadow-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-[#111111] font-outfit uppercase">Đăng ký</h1>
            <p class="text-xs text-[#666666] mt-2 uppercase tracking-wider">TS Battery - Power Your Everyday</p>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Tên đăng nhập (Username)</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2.5 text-sm text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Ví dụ: tsbatteryuser" required autofocus>
                @error('name')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Địa chỉ Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2.5 text-sm text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Ví dụ: user@tsbattery.com" required>
                @error('email')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Mật khẩu</label>
                <input type="password" id="password" name="password" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2.5 text-sm text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Tối thiểu 6 ký tự" required>
                @error('password')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2.5 text-sm text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Nhập lại mật khẩu" required>
            </div>

            <button type="submit" class="w-full bg-[#111111] hover:bg-[#2E9F5B] text-white text-xs font-semibold uppercase tracking-widest py-3 rounded transition-colors duration-300 mt-4 cursor-pointer">
                Đăng ký tài khoản
            </button>
        </form>

        <div class="border-t border-[#ECECEC] mt-6 pt-6 text-center text-xs text-[#666666]">
            Đã có tài khoản? 
            <a href="{{ route('login') }}" class="text-[#2E9F5B] hover:underline font-semibold ml-1">Đăng nhập</a>
        </div>
    </div>
</div>
@endsection
