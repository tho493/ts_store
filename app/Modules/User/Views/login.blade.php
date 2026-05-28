@extends('layouts.app')

@section('title', 'Đăng nhập tài khoản - TS Battery')

@section('content')
<div class="max-w-md mx-auto my-16 px-4">
    <div class="bg-white border border-[#ECECEC] p-8 rounded-lg shadow-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-[#111111] font-outfit uppercase">Đăng nhập</h1>
            <p class="text-xs text-[#666666] mt-2 uppercase tracking-wider">TS Battery - Power Your Everyday</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-[#F0FDF4] border border-[#D1FAE5] text-[#2E9F5B] text-xs p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            
            <div class="flex flex-col gap-1.5">
                <label for="login" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Email hoặc Username</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2.5 text-sm text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Nhập email hoặc tên đăng nhập" required autofocus>
                @error('login')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-semibold uppercase tracking-wider text-[#666666]">Mật khẩu</label>
                <input type="password" id="password" name="password" class="w-full bg-[#F7F7F7] border border-[#ECECEC] rounded px-4 py-2.5 text-sm text-[#111111] placeholder-[#A0A0A0] focus:outline-none focus:border-[#2E9F5B] transition-colors" placeholder="Nhập mật khẩu" required>
                @error('password')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs mt-2">
                <label class="flex items-center gap-2 text-[#666666] cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-[#ECECEC] text-[#2E9F5B] focus:ring-[#2E9F5B]">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-[#111111] hover:bg-[#2E9F5B] text-white text-xs font-semibold uppercase tracking-widest py-3 rounded transition-colors duration-300 mt-4 cursor-pointer">
                Đăng nhập
            </button>
        </form>

        <div class="border-t border-[#ECECEC] mt-6 pt-6 text-center text-xs text-[#666666]">
            Chưa có tài khoản? 
            <a href="{{ route('register') }}" class="text-[#2E9F5B] hover:underline font-semibold ml-1">Đăng ký ngay</a>
        </div>
    </div>
</div>
@endsection
