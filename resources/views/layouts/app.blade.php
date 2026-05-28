<!DOCTYPE html>
<html lang="vi" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TS Battery - Power Your Everyday')</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="@yield('meta_description', 'TS Battery - Thương hiệu cung cấp các sản phẩm pin laptop, pin điện thoại, pin sạc dự phòng và pin công nghiệp chất lượng cao, bền bỉ và an toàn.')">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="@yield('title', 'TS Battery - Power Your Everyday')">
    <meta property="og:description" content="@yield('meta_description', 'Thương hiệu cung cấp các sản phẩm pin chất lượng cao, bền bỉ và an toàn.')">
    <meta property="og:type" content="website">

    <!-- Fonts (Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Hiệu ứng vẽ nét SVG cho chữ TS */
        @keyframes drawT {
            to { stroke-dashoffset: 0; }
        }
        @keyframes drawS {
            to { stroke-dashoffset: 0; }
        }
        .path-t {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: drawT 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .path-s {
            stroke-dasharray: 150;
            stroke-dashoffset: 150;
            animation: drawS 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s forwards;
        }
    </style>
</head>
<body class="h-full bg-[#F7F7F7] text-[#111111] font-sans antialiased flex flex-col min-h-screen">

    <!-- SPLASH SCREEN -->
    <div id="splash-screen" class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white transition-opacity duration-300">
        <div class="relative w-36 h-36 flex items-center justify-center">
            <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Chữ T -->
                <path class="path-t" d="M25 35 H75 M50 35 V75" stroke="#2E9F5B" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                <!-- Chữ S -->
                <path class="path-s" d="M32 58 C 30 72, 70 74, 68 62 C 67 52, 33 50, 32 42 C 30 30, 70 28, 68 40" stroke="#111111" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 class="mt-4 text-lg font-semibold tracking-wider text-[#111111] font-outfit">TS BATTERY</h2>
        <p class="text-xs text-[#666666] tracking-widest mt-1 uppercase">Power Your Everyday</p>
    </div>

    <!-- HEADER (Sticky + Backdrop Blur) -->
    <header class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-[#ECECEC] transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 flex-shrink-0">
                <span class="text-2xl font-bold tracking-tight text-[#111111] font-outfit">
                    TS<span class="text-[#2E9F5B]">.</span>Battery
                </span>
            </a>

            <!-- Search Bar (Center - Important UX) -->
            <div class="flex-1 max-w-lg hidden md:block">
                @livewire('product-search')
            </div>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-[#666666]">
                <a href="/" class="hover:text-[#2E9F5B] transition-colors duration-200">Trang chủ</a>
                <a href="/?category=pin-laptop" class="hover:text-[#2E9F5B] transition-colors duration-200">Pin Laptop</a>
                <a href="/?category=pin-dien-thoai" class="hover:text-[#2E9F5B] transition-colors duration-200">Pin Điện thoại</a>
                <a href="/?category=pin-sac-du-phong" class="hover:text-[#2E9F5B] transition-colors duration-200">Pin Dự phòng</a>
                <a href="/?category=pin-cong-nghiep-lithium" class="hover:text-[#2E9F5B] transition-colors duration-200">Pin Công nghiệp</a>
            </nav>

            <!-- Actions (Cart / Hotline / Auth) -->
            <div class="flex items-center gap-4 flex-shrink-0">
                @if(setting('enable_shopping_cart', true))
                    <!-- Biểu tượng Giỏ hàng -->
                    @livewire('cart-icon')
                @else
                    <!-- Hotline thay thế giỏ hàng -->
                    <a href="tel:{{ setting('hotline', '0987.654.321') }}" class="flex items-center gap-2 border border-[#2E9F5B] text-[#2E9F5B] hover:bg-[#F0FDF4] px-4 py-2 rounded text-xs font-semibold uppercase tracking-wider transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.157-5.02-3.356-6.176-6.18l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                        <span>Hotline</span>
                    </a>
                @endif

                <!-- User Authentication Dropdown -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-1 text-xs font-semibold uppercase tracking-wider text-[#111111] hover:text-[#2E9F5B] transition-colors duration-200 cursor-pointer">
                            <span class="max-w-[80px] sm:max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-[#ECECEC] rounded shadow-lg py-1.5 z-50 text-xs text-[#111111]">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-[#F7F7F7] font-semibold text-[#2E9F5B] border-b border-[#ECECEC] mb-1">Trang quản trị</a>
                            @endif
                            <a href="{{ route('my_orders') }}" class="block px-4 py-2 hover:bg-[#F7F7F7]">Đơn hàng của tôi</a>
                            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-500 hover:bg-[#F7F7F7] cursor-pointer font-medium">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold uppercase tracking-wider text-[#666666] hover:text-[#2E9F5B] transition-colors duration-200">Đăng nhập</a>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden text-[#111111] hover:text-[#2E9F5B] p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- MOBILE NAVIGATION MENU -->
    <div id="mobile-menu" class="fixed inset-0 z-50 bg-black/20 backdrop-blur-sm hidden transition-all duration-300">
        <div class="fixed top-0 right-0 bottom-0 w-4/5 max-w-sm bg-white p-6 shadow-2xl flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-[#ECECEC] pb-4">
                <span class="text-xl font-bold tracking-tight text-[#111111] font-outfit">Menu</span>
                <button id="mobile-menu-close" class="text-[#666666] hover:text-[#111111]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Search trên mobile -->
            <div class="md:hidden">
                @livewire('product-search')
            </div>
            <nav class="flex flex-col gap-4 text-base font-medium text-[#111111]">
                <a href="/" class="hover:text-[#2E9F5B] py-2">Trang chủ</a>
                <a href="/?category=pin-laptop" class="hover:text-[#2E9F5B] py-2">Pin Laptop</a>
                <a href="/?category=pin-dien-thoai" class="hover:text-[#2E9F5B] py-2">Pin Điện thoại</a>
                <a href="/?category=pin-sac-du-phong" class="hover:text-[#2E9F5B] py-2">Pin Dự phòng</a>
                <a href="/?category=pin-cong-nghiep-lithium" class="hover:text-[#2E9F5B] py-2">Pin Công nghiệp</a>
            </nav>
            <div class="mt-auto border-t border-[#ECECEC] pt-6 flex flex-col gap-4">
                @auth
                    <div class="flex flex-col gap-2 border-b border-[#ECECEC] pb-4">
                        <span class="text-xs text-[#666666] font-semibold uppercase tracking-wider">Tài khoản: {{ auth()->user()->name }}</span>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-[#2E9F5B] hover:underline">Trang quản trị</a>
                        @endif
                        <a href="{{ route('my_orders') }}" class="text-sm font-medium text-[#111111] hover:underline">Đơn hàng của tôi</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 font-semibold cursor-pointer">Đăng xuất</button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-col gap-2 border-b border-[#ECECEC] pb-4">
                        <a href="{{ route('login') }}" class="flex items-center justify-center border border-[#111111] text-[#111111] py-2.5 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#F7F7F7]">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="flex items-center justify-center bg-[#111111] text-white py-2.5 rounded text-xs font-semibold uppercase tracking-wider hover:bg-[#2E9F5B]">Đăng ký</a>
                    </div>
                @endauth
                <a href="tel:{{ setting('hotline', '0987.654.321') }}" class="flex items-center justify-center gap-2 bg-[#2E9F5B] text-white py-3 rounded text-sm font-semibold uppercase tracking-wider">
                    <span>Gọi điện tư vấn: {{ setting('hotline', '0987.654.321') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main class="flex-1 w-full">
        <!-- Flash Messages -->
        @if(session('success') || session('error') || session('warning'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                @if(session('success'))
                    <div class="bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5] text-xs p-4 rounded flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 text-red-700 border border-red-200 text-xs p-4 rounded flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="bg-amber-50 text-amber-700 border border-amber-200 text-xs p-4 rounded flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
        @isset($slot)
            {{ $slot }}
        @endisset
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-[#ECECEC] mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand -->
                <div class="flex flex-col gap-3">
                    <span class="text-xl font-bold tracking-tight text-[#111111] font-outfit">TS.Battery</span>
                    <p class="text-sm text-[#666666]">Power Your Everyday</p>
                    <p class="text-xs text-[#666666] mt-4">&copy; {{ date('Y') }} <a href="https://github.com/tho493" class="hover:underline text-[#111111]">tho493</a>. Bảo lưu mọi quyền.</p>
                </div>
                <!-- Contact info -->
                <div class="flex flex-col gap-3">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-[#111111]">Thông tin liên hệ</h3>
                    <p class="text-sm text-[#666666]">Hotline: {{ setting('hotline', '0987.654.321') }}</p>
                    <p class="text-sm text-[#666666]">Địa chỉ: {{ setting('address', '123 Đường Năng Lượng, Hà Nội') }}</p>
                </div>
                <!-- Links -->
                <div class="flex flex-col gap-3">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-[#111111]">Liên kết nhanh</h3>
                    <div class="flex gap-4">
                        <a href="{{ setting('zalo_link', '#') }}" target="_blank" class="text-sm text-[#2E9F5B] hover:underline">Zalo</a>
                        <a href="{{ setting('messenger_link', '#') }}" target="_blank" class="text-sm text-[#2E9F5B] hover:underline">Messenger</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Drawer (Nếu bật giỏ hàng) -->
    @if(setting('enable_shopping_cart', true))
        @livewire('cart-drawer')
    @endif

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- JavaScript xử lý Splash Screen & Mobile Menu -->
    <script>
        // Xử lý Splash Screen nhanh
        document.addEventListener('DOMContentLoaded', () => {
            const splash = document.getElementById('splash-screen');
            if (sessionStorage.getItem('ts_splash_shown')) {
                splash.style.display = 'none';
            } else {
                setTimeout(() => {
                    splash.classList.add('opacity-0');
                    setTimeout(() => {
                        splash.style.display = 'none';
                        sessionStorage.setItem('ts_splash_shown', 'true');
                    }, 300);
                }, 1000); // 1.0 giây vẽ hoạt ảnh rồi biến mất
            }

            // Mobile Menu Open/Close
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu && mobileMenuClose) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.remove('hidden');
                });

                mobileMenuClose.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });

                mobileMenu.addEventListener('click', (e) => {
                    if (e.target === mobileMenu) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
