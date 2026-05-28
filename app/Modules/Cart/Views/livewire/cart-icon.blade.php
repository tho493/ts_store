<button wire:click="openCart" class="relative p-2 text-[#111111] hover:text-[#2E9F5B] transition-colors duration-200 focus:outline-none">
    <!-- Icon Shopping Bag tối giản -->
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
    </svg>
    
    @if($totalQuantity > 0)
        <span class="absolute top-1 right-1 bg-[#2E9F5B] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center animate-pulse">
            {{ $totalQuantity }}
        </span>
    @endif
</button>
