<div x-data="{ mobileFiltersOpen: false }">
    <!-- HERO SECTION (Tối giản - Clean) -->
    <section class="bg-white border-b border-[#ECECEC] py-10 sm:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Left content -->
            <div class="flex flex-col gap-5">
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E9F5B]">Thương hiệu uy tín</span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#111111] font-outfit leading-tight">
                    Năng lượng bền bỉ cho mọi hành trình
                </h1>
                <p class="text-sm sm:text-base text-[#666666] leading-relaxed max-w-lg">
                    TS Battery cung cấp giải pháp năng lượng tối ưu, bền bỉ và tuyệt đối an toàn. Chuyên cung cấp các loại pin laptop, pin điện thoại, sạc dự phòng hiệu năng cao và pin lưu trữ năng lượng công nghiệp.
                </p>
                <div class="flex gap-4">
                    <a href="#catalog" class="inline-block bg-[#2E9F5B] text-white font-semibold text-sm uppercase tracking-wider px-6 sm:px-8 py-3 sm:py-3.5 rounded hover:bg-[#238247] transition duration-200">
                        Khám phá sản phẩm
                    </a>
                </div>
            </div>
            <!-- Right content (Product Showcase) - ẩn trên mobile nhỏ -->
            <div class="hidden sm:flex justify-center lg:justify-end">
                <div class="relative w-full max-w-sm bg-[#F7F7F7] border border-[#ECECEC] rounded-lg aspect-square flex items-center justify-center p-8 overflow-hidden">
                    <div class="w-32 sm:w-40 h-52 sm:h-64 bg-white border border-[#ECECEC] rounded-2xl relative flex flex-col items-center justify-center p-4">
                        <div class="w-12 h-4 bg-[#2E9F5B] rounded-t-lg absolute -top-4"></div>
                        <div class="w-full flex-1 bg-[#F0FDF4] border border-[#D1FAE5] rounded-xl flex flex-col items-center justify-center gap-2 overflow-hidden relative">
                            <div class="absolute bottom-0 left-0 right-0 bg-[#2E9F5B] h-4/5"></div>
                            <span class="text-xl font-bold tracking-tight text-white z-10 font-outfit">TS</span>
                            <span class="text-[10px] text-white/80 z-10 font-medium">80%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCT CATALOG & FILTERS -->
    <section id="catalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-16">

        <!-- Toolbar (Mobile: nút filter + sort) -->
        <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-[#ECECEC]">
            <p class="text-sm text-[#666666]">
                Hiển thị <span class="font-bold text-[#111111]">{{ $products->total() }}</span> sản phẩm
                @if(!empty($search)) cho "<span class="font-bold text-[#111111]">{{ $search }}</span>"@endif
            </p>

            <div class="flex items-center gap-2">
                <!-- Nút Bộ lọc - Chỉ hiện trên Mobile -->
                <button
                    @click="mobileFiltersOpen = true"
                    class="lg:hidden flex items-center gap-1.5 border border-[#ECECEC] text-xs font-semibold text-[#666666] px-3 py-1.5 rounded hover:bg-[#F7F7F7] transition cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12"></path></svg>
                    Bộ lọc
                    @if(!empty($category) || !empty($brand))
                        <span class="bg-[#2E9F5B] text-white rounded-full w-4 h-4 flex items-center justify-center text-[9px] font-bold leading-none">!</span>
                    @endif
                </button>

                <!-- Sort -->
                <div class="flex items-center gap-2">
                    <label for="sort" class="text-xs text-[#666666] hidden sm:block whitespace-nowrap">Sắp xếp:</label>
                    <select
                        id="sort"
                        wire:model.live="sort"
                        class="bg-[#F7F7F7] text-xs text-[#111111] border border-[#ECECEC] rounded px-2 sm:px-3 py-1.5 focus:outline-none focus:border-[#2E9F5B] transition-colors"
                    >
                        <option value="newest">Mới nhất</option>
                        <option value="price_asc">Giá tăng dần</option>
                        <option value="price_desc">Giá giảm dần</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- MOBILE FILTER DRAWER -->
        <div x-show="mobileFiltersOpen" class="fixed inset-0 z-50 flex lg:hidden" x-cloak>
            <!-- Backdrop -->
            <div @click="mobileFiltersOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
            <!-- Drawer (trượt từ bên phải) -->
            <div class="relative ml-auto flex w-80 max-w-[90vw] flex-col bg-white shadow-xl overflow-y-auto">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#ECECEC] sticky top-0 bg-white z-10">
                    <h3 class="text-sm font-bold text-[#111111] uppercase tracking-wider">Bộ lọc</h3>
                    <button @click="mobileFiltersOpen = false" class="text-[#666666] hover:text-[#111111] p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <!-- Filter Content -->
                <div class="flex flex-col gap-6 p-6">
                    <!-- Danh mục -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-[#111111] mb-3">Danh mục</h4>
                        <div class="flex flex-col gap-2">
                            <button wire:click="selectCategory('')" @click="mobileFiltersOpen = false" class="text-left text-sm py-1.5 transition {{ empty($category) ? 'text-[#2E9F5B] font-bold' : 'text-[#666666]' }}">
                                Tất cả sản phẩm
                            </button>
                            @foreach($categoriesList as $cat)
                                <button wire:click="selectCategory('{{ $cat->slug }}')" @click="mobileFiltersOpen = false" class="text-left text-sm py-1.5 transition {{ $category === $cat->slug ? 'text-[#2E9F5B] font-bold' : 'text-[#666666]' }}">
                                    {{ $cat->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <hr class="border-[#ECECEC]">
                    <!-- Thương hiệu -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-[#111111] mb-3">Thương hiệu</h4>
                        <div class="flex flex-col gap-2">
                            <button wire:click="selectBrand('')" @click="mobileFiltersOpen = false" class="text-left text-sm py-1.5 transition {{ empty($brand) ? 'text-[#2E9F5B] font-bold' : 'text-[#666666]' }}">
                                Tất cả thương hiệu
                            </button>
                            @foreach($brandsList as $b)
                                <button wire:click="selectBrand('{{ $b }}')" @click="mobileFiltersOpen = false" class="text-left text-sm py-1.5 transition {{ $brand === $b ? 'text-[#2E9F5B] font-bold' : 'text-[#666666]' }}">
                                    {{ $b }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @if(!empty($category) || !empty($brand) || !empty($search))
                        <hr class="border-[#ECECEC]">
                        <button wire:click="resetFilters" @click="mobileFiltersOpen = false" class="w-full text-center border border-[#ECECEC] text-xs font-semibold py-2.5 rounded hover:bg-[#F7F7F7] hover:text-[#111111] transition text-[#666666] uppercase tracking-wider">
                            Xóa toàn bộ bộ lọc
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
            
            <!-- SIDEBAR BỘ LỌC - Desktop only -->
            <aside class="hidden lg:flex flex-col gap-8">
                <!-- Danh mục -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] mb-4">Danh mục</h3>
                    <div class="flex flex-col gap-2">
                        <button wire:click="selectCategory('')" class="text-left text-sm py-1.5 transition duration-150 {{ empty($category) ? 'text-[#2E9F5B] font-bold' : 'text-[#666666] hover:text-[#111111]' }}">
                            Tất cả sản phẩm
                        </button>
                        @foreach($categoriesList as $cat)
                            <button wire:click="selectCategory('{{ $cat->slug }}')" class="text-left text-sm py-1.5 transition duration-150 {{ $category === $cat->slug ? 'text-[#2E9F5B] font-bold' : 'text-[#666666] hover:text-[#111111]' }}">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <hr class="border-[#ECECEC]">

                <!-- Thương hiệu -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] mb-4">Thương hiệu</h3>
                    <div class="flex flex-col gap-2">
                        <button wire:click="selectBrand('')" class="text-left text-sm py-1.5 transition duration-150 {{ empty($brand) ? 'text-[#2E9F5B] font-bold' : 'text-[#666666] hover:text-[#111111]' }}">
                            Tất cả thương hiệu
                        </button>
                        @foreach($brandsList as $b)
                            <button wire:click="selectBrand('{{ $b }}')" class="text-left text-sm py-1.5 transition duration-150 {{ $brand === $b ? 'text-[#2E9F5B] font-bold' : 'text-[#666666] hover:text-[#111111]' }}">
                                {{ $b }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Xóa bộ lọc (nếu có chọn) -->
                @if(!empty($category) || !empty($brand) || !empty($search))
                    <div>
                        <button wire:click="resetFilters" class="w-full text-center border border-[#ECECEC] text-xs font-semibold py-2.5 rounded hover:bg-[#F7F7F7] hover:text-[#111111] transition duration-150 text-[#666666] uppercase tracking-wider">
                            Xóa toàn bộ bộ lọc
                        </button>
                    </div>
                @endif
            </aside>

            <!-- LƯỚI SẢN PHẨM -->
            <div class="lg:col-span-3 flex flex-col gap-6">
                @if($products->isEmpty())
                    <div class="py-16 sm:py-24 text-center">
                        <svg class="w-12 h-12 text-[#666666] mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-sm font-semibold text-[#111111]">Không tìm thấy sản phẩm phù hợp</h4>
                        <p class="text-xs text-[#666666] mt-1">Vui lòng thử lại với các tiêu chí lọc khác.</p>
                    </div>
                @else
                    <!-- 2 cột trên mobile, 3 cột trên màn hình to hơn -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                        @foreach($products as $product)
                            @include('product::components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <!-- Phân trang -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
