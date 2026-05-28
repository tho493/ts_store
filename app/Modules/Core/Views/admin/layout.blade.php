<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#F7F7F7]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - TS Battery</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="h-full text-[#111111] font-sans antialiased" x-data="{ mobileSidebarOpen: false }">

    <!-- SIDEBAR MOBILE DRAWER (OVERLAY) -->
    <div x-show="mobileSidebarOpen" class="fixed inset-0 z-50 flex md:hidden" x-cloak>
        <!-- Backdrop -->
        <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
        <!-- Drawer content -->
        <div class="relative flex w-72 max-w-[85vw] flex-col bg-white shadow-xl z-10 justify-between h-full">
            <div class="p-6">
                <!-- Brand + Close Button -->
                <div class="pb-6 border-b border-[#ECECEC] mb-6 flex items-center justify-between">
                    <a href="/" class="text-xl font-bold tracking-tight text-[#111111] font-outfit">
                        TS<span class="text-[#2E9F5B]">.</span>Battery <span class="text-[10px] bg-[#F7F7F7] border border-[#ECECEC] px-1.5 py-0.5 rounded text-[#666666] font-normal uppercase ml-1">Admin</span>
                    </a>
                    <button @click="mobileSidebarOpen = false" class="text-[#666666] hover:text-[#111111] p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Nav Links -->
                <nav class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wider text-[#666666]">
                    <a href="{{ route('admin.dashboard') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Dashboard & Cài đặt
                    </a>
                    <a href="{{ route('admin.categories') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.categories') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý danh mục
                    </a>
                    <a href="{{ route('admin.products') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.products') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý sản phẩm
                    </a>
                    <a href="{{ route('admin.users') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.users') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý tài khoản
                    </a>
                    <a href="{{ route('admin.inventory') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.inventory*') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý kho
                    </a>
                    @if(setting('enable_shopping_cart', true))
                        <a href="{{ route('admin.orders') }}" @click="mobileSidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.orders') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                            Quản lý đơn hàng
                        </a>
                    @endif
                </nav>
            </div>

            <div class="p-6 border-t border-[#ECECEC] flex flex-col gap-4">
                <a href="/" class="text-xs font-semibold text-[#666666] hover:text-[#2E9F5B] flex items-center gap-2">
                    &larr; Xem Trang chủ
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline text-left cursor-pointer">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- LAYOUT WRAPPER -->
    <div class="flex h-full min-h-screen">

        <!-- SIDEBAR (Flat & Minimal) - Desktop only -->
        <aside class="hidden md:flex w-64 bg-white border-r border-[#ECECEC] flex-col justify-between h-screen sticky top-0 flex-shrink-0 z-30">
            <div class="p-6">
                <!-- Brand -->
                <div class="pb-6 border-b border-[#ECECEC] mb-8">
                    <a href="/" class="text-xl font-bold tracking-tight text-[#111111] font-outfit">
                        TS<span class="text-[#2E9F5B]">.</span>Battery <span class="text-[10px] bg-[#F7F7F7] border border-[#ECECEC] px-1.5 py-0.5 rounded text-[#666666] font-normal uppercase ml-1">Admin</span>
                    </a>
                </div>

                <!-- Nav Links -->
                <nav class="flex flex-col gap-1 text-xs font-semibold uppercase tracking-wider text-[#666666]">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Dashboard & Cài đặt
                    </a>
                    <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.categories') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý danh mục
                    </a>
                    <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.products') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý sản phẩm
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.users') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý tài khoản
                    </a>
                    <a href="{{ route('admin.inventory') }}" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.inventory*') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                        Quản lý kho
                    </a>
                    @if(setting('enable_shopping_cart', true))
                        <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded transition {{ request()->routeIs('admin.orders') ? 'bg-[#F0FDF4] text-[#2E9F5B]' : 'hover:bg-[#F7F7F7] hover:text-[#111111]' }}">
                            Quản lý đơn hàng
                        </a>
                    @endif
                </nav>
            </div>

            <div class="p-6 border-t border-[#ECECEC] flex flex-col gap-4">
                <a href="/" class="text-xs font-semibold text-[#666666] hover:text-[#2E9F5B] flex items-center gap-2">
                    &larr; Xem Trang chủ
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline text-left cursor-pointer">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN BODY -->
        <div class="flex-1 min-h-screen flex flex-col min-w-0">
            
            <!-- Top bar -->
            <header class="bg-white border-b border-[#ECECEC] h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileSidebarOpen = true" class="md:hidden text-[#111111] hover:text-[#2E9F5B] p-1.5 -ml-1 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                    </button>
                    <h2 class="text-sm md:text-base font-bold text-[#111111] font-outfit uppercase truncate">@yield('page_title', 'Hệ thống quản trị')</h2>
                </div>
                <!-- Mobile: Brand logo -->
                <a href="/" class="md:hidden text-base font-bold tracking-tight text-[#111111] font-outfit">
                    TS<span class="text-[#2E9F5B]">.</span>
                </a>
            </header>

            <!-- Main content area -->
            <main class="flex-1 p-4 md:p-8">
                
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5] text-xs p-4 rounded mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 text-red-700 border border-red-200 text-xs p-4 rounded mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('admin_content')

            </main>

        </div>

    </div>

</body>
</html>
