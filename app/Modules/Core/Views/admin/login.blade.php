<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#F7F7F7]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Đăng nhập quản trị - TS Battery</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-[#111111] font-sans antialiased flex items-center justify-center p-4">

    <div class="w-full max-w-sm bg-white border border-[#ECECEC] rounded-lg p-6 sm:p-8 flex flex-col gap-6">
        
        <!-- Header -->
        <div class="text-center">
            <span class="text-2xl font-bold tracking-tight text-[#111111] font-outfit">
                TS<span class="text-[#2E9F5B]">.</span>Battery
            </span>
            <h1 class="text-sm font-bold uppercase tracking-wider text-[#666666] mt-2">Đăng nhập hệ thống quản trị</h1>
        </div>

        <!-- Alert messages -->
        @if(session('success'))
            <div class="bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5] text-[11px] p-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-700 border border-red-200 text-[11px] p-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="flex flex-col gap-5">
            @csrf

            <!-- Login (Email/Username) -->
            <div class="flex flex-col gap-1.5">
                <label for="login" class="text-xs font-semibold text-[#111111]">Email hoặc Tên đăng nhập</label>
                <input 
                    type="text" 
                    id="login" 
                    name="login" 
                    value="{{ old('login') }}"
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('login') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    placeholder="email hoặc username"
                    required
                    autofocus
                />
                @error('login') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-semibold text-[#111111]">Mật khẩu</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full bg-[#F7F7F7] text-xs text-[#111111] border @error('password') border-red-500 @else border-[#ECECEC] @enderror rounded px-4 py-2.5 focus:outline-none focus:border-[#2E9F5B] focus:bg-white transition"
                    placeholder="••••••••"
                    required
                />
                @error('password') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Remember me -->
            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="rounded text-[#2E9F5B] focus:ring-[#2E9F5B] border-[#ECECEC]"
                />
                <label for="remember" class="text-xs text-[#666666]">Ghi nhớ đăng nhập</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="bg-[#2E9F5B] text-white py-3 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#238247] transition">
                Đăng nhập
            </button>
        </form>

        <div class="text-center pt-2 border-t border-[#ECECEC]">
            <a href="/" class="text-xs text-[#666666] hover:text-[#2E9F5B]">&larr; Quay lại trang chủ website</a>
        </div>

    </div>

</body>
</html>
