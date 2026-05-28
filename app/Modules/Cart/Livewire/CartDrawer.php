<?php

namespace App\Modules\Cart\Livewire;

use Livewire\Component;
use App\Modules\Cart\Services\CartService;
use Livewire\Attributes\On;

class CartDrawer extends Component
{
    public bool $isOpen = false;
    public array $cart = [];
    public float $totalAmount = 0;

    protected $listeners = [
        'toggleCartDrawer' => 'toggle',
        'addToCart' => 'addToCart',
        'cartUpdated' => 'loadCart'
    ];

    public function mount(CartService $cartService)
    {
        $this->loadCart($cartService);
    }

    #[On('toggleCartDrawer')]
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    #[On('cartUpdated')]
    public function loadCart(CartService $cartService)
    {
        $this->cart = $cartService->getCart();
        $this->totalAmount = $cartService->getTotalAmount();
    }

    #[On('addToCart')]
    public function addToCart(CartService $cartService, int $productId, int $quantity = 1)
    {
        $cartService->add($productId, $quantity);
        $this->loadCart($cartService);
        $this->dispatch('cartUpdated');
        
        // Tự động mở giỏ hàng khi người dùng thêm sản phẩm mới
        $this->isOpen = true;
    }

    public function updateQuantity(CartService $cartService, int $productId, int $quantity)
    {
        $cartService->updateQuantity($productId, $quantity);
        $this->loadCart($cartService);
        $this->dispatch('cartUpdated');
    }

    public function removeItem(CartService $cartService, int $productId)
    {
        $cartService->remove($productId);
        $this->loadCart($cartService);
        $this->dispatch('cartUpdated');
    }

    public function checkout()
    {
        // Khi thanh toán, chuyển hướng đến trang checkout
        return redirect()->to('/checkout');
    }

    public function render()
    {
        return view('cart::livewire.cart-drawer');
    }
}
