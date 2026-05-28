@extends('layouts.app')

@section('title', $product->name . ' - TS Battery')
@section('meta_description', Str::limit(strip_tags($product->description), 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ activeImage: '{{ $product->thumbnail ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail)) : '' }}' }">
    
    <!-- Breadcrumb -->
    <nav class="flex text-xs text-[#666666] mb-8 gap-2">
        <a href="/" class="hover:text-[#111111] transition-colors">Trang chủ</a>
        <span>/</span>
        <a href="/?category={{ $product->category->slug ?? '' }}" class="hover:text-[#111111] transition-colors">{{ $product->category->name ?? 'Pin' }}</a>
        <span>/</span>
        <span class="text-[#111111] font-medium truncate">{{ $product->name }}</span>
    </nav>

    <!-- Product Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start bg-white border border-[#ECECEC] rounded-lg p-6 sm:p-8">
        
        <!-- Left: Image Gallery (Tối giản - Flat) -->
        <div class="flex flex-col gap-4">
            <div class="aspect-square bg-[#F7F7F7] border border-[#ECECEC] rounded flex items-center justify-center p-12">
                <template x-if="activeImage">
                    <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-contain">
                </template>
                <template x-if="!activeImage">
                    <svg class="w-24 h-24 text-[#2E9F5B]" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
                    </svg>
                </template>
            </div>
            
            @if($product->thumbnail || !$product->images->isEmpty())
                <div class="flex gap-3 overflow-x-auto pb-2 mt-2">
                    @if($product->thumbnail)
                        <button 
                            @click="activeImage = '{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail) }}'"
                            class="w-16 h-16 border rounded p-1 bg-[#F7F7F7] hover:border-[#2E9F5B] transition-colors focus:outline-none flex-shrink-0"
                            :class="{'border-[#2E9F5B]': activeImage === '{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail) }}'}"
                        >
                            <img src="{{ str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail) }}" alt="Thumb" class="w-full h-full object-contain">
                        </button>
                    @endif
                    @foreach($product->images as $img)
                        <button 
                            @click="activeImage = '{{ asset('storage/' . $img->image) }}'"
                            class="w-16 h-16 border rounded p-1 bg-[#F7F7F7] hover:border-[#2E9F5B] transition-colors focus:outline-none flex-shrink-0"
                            :class="{'border-[#2E9F5B]': activeImage === '{{ asset('storage/' . $img->image) }}'}"
                        >
                            <img src="{{ asset('storage/' . $img->image) }}" alt="Sub" class="w-full h-full object-contain">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Product Info -->
        <div class="flex flex-col gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#666666]">{{ $product->category->name ?? 'Pin' }}</span>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#111111] mt-1 font-outfit">{{ $product->name }}</h1>
                <p class="text-xs text-[#666666] mt-2">Mã sản phẩm (SKU): <span class="font-semibold text-[#111111]">{{ $product->sku }}</span></p>
            </div>

            <!-- Giá bán -->
            <div class="py-4 border-t border-b border-[#ECECEC] flex items-baseline gap-4">
                @if($product->sale_price)
                    <span class="text-3xl font-extrabold text-[#2E9F5B]">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                    <span class="text-sm text-[#666666] line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @else
                    <span class="text-3xl font-extrabold text-[#111111]">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @endif
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="text-sm text-[#666666] leading-relaxed">
                {!! nl2br(e($product->description)) !!}
            </div>

            <!-- Nút mua hàng / liên hệ động (Dùng Alpine.js dispatch sang Livewire) -->
            <div>
                @if(setting('enable_shopping_cart', true))
                    <button 
                        @click="$dispatch('addToCart', { productId: {{ $product->id }} })"
                        class="w-full bg-[#2E9F5B] text-white py-3.5 px-8 rounded text-sm font-semibold uppercase tracking-wider hover:bg-[#238247] transition duration-200 focus:outline-none text-center"
                    >
                        Thêm vào giỏ hàng
                    </button>
                @else
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a 
                            href="{{ setting('zalo_link', '#') }}" 
                            target="_blank"
                            class="flex-1 bg-[#2E9F5B] text-white py-3.5 px-8 rounded text-sm font-semibold uppercase tracking-wider hover:bg-[#238247] transition duration-200 text-center"
                        >
                            Tư vấn qua Zalo
                        </a>
                        <a 
                            href="tel:{{ setting('hotline', '0987.654.321') }}" 
                            class="flex-1 border border-[#111111] text-[#111111] py-3.5 px-8 rounded text-sm font-semibold uppercase tracking-wider hover:bg-[#111111] hover:text-white transition duration-200 text-center"
                        >
                            Gọi Hotline: {{ setting('hotline', '0987.654.321') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Bảng thông số kỹ thuật (Flat Table) -->
            @if(!empty($product->specifications))
                <div class="mt-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#111111] mb-3">Thông số kỹ thuật</h3>
                    <div class="border border-[#ECECEC] rounded overflow-hidden">
                        <table class="w-full text-left border-collapse text-xs">
                            <tbody>
                                @foreach($product->specifications as $key => $value)
                                    <tr class="border-b border-[#ECECEC] last:border-0 hover:bg-[#F7F7F7] transition-colors">
                                        <td class="px-4 py-3 font-semibold text-[#111111] bg-[#F7F7F7] w-1/3">{{ $key }}</td>
                                        <td class="px-4 py-3 text-[#666666]">{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Related Products -->
    @if(!$relatedProducts->isEmpty())
        <section class="mt-20">
            <h2 class="text-lg font-bold tracking-tight text-[#111111] font-outfit uppercase mb-8">Sản phẩm liên quan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    @include('product::components.product-card', ['product' => $related])
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
