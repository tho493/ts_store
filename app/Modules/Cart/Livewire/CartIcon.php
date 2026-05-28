<?php

namespace App\Modules\Cart\Livewire;

use Livewire\Component;
use App\Modules\Cart\Services\CartService;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    public int $totalQuantity = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount(CartService $cartService)
    {
        $this->totalQuantity = $cartService->getTotalQuantity();
    }

    #[On('cartUpdated')]
    public function updateCount(CartService $cartService)
    {
        $this->totalQuantity = $cartService->getTotalQuantity();
    }

    public function openCart()
    {
        $this->dispatch('toggleCartDrawer');
    }

    public function render()
    {
        return view('cart::livewire.cart-icon');
    }
}
