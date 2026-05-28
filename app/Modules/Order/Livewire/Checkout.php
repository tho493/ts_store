<?php

namespace App\Modules\Order\Livewire;

use Livewire\Component;
use App\Modules\Cart\Services\CartService;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderItem;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Services\InventoryService;
use Illuminate\Support\Str;

class Checkout extends Component
{
    // Form fields
    public string $customer_name = '';
    public string $customer_phone = '';
    public string $customer_address = '';
    public string $customer_email = '';
    public string $payment_method = 'COD';

    // Giỏ hàng
    public array $cart = [];
    public float $totalAmount = 0;
    public bool $orderPlaced = false;
    public string $placedOrderCode = '';

    protected array $rules = [
        'customer_name' => 'required|min:3',
        'customer_phone' => 'required|regex:/^[0-9]{9,11}$/',
        'customer_address' => 'required|min:10',
        'customer_email' => 'nullable|email',
        'payment_method' => 'required|in:COD,Bank'
    ];

    protected array $messages = [
        'customer_name.required' => 'Vui lòng nhập họ và tên.',
        'customer_name.min' => 'Họ và tên phải có ít nhất 3 ký tự.',
        'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
        'customer_phone.regex' => 'Số điện thoại không đúng định dạng (9 đến 11 số).',
        'customer_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
        'customer_address.min' => 'Địa chỉ nhận hàng phải chi tiết hơn (tối thiểu 10 ký tự).',
        'customer_email.email' => 'Địa chỉ email không đúng định dạng.'
    ];

    public function mount(CartService $cartService)
    {
        // Chặn truy cập nếu tính năng giỏ hàng bị tắt
        if (!setting('enable_shopping_cart', true)) {
            return redirect()->to('/');
        }

        // Bắt buộc đăng nhập để đặt hàng
        if (!auth()->check()) {
            session()->flash('error', 'Vui lòng đăng nhập tài khoản khách hàng để tiến hành đặt hàng.');
            return redirect()->route('login');
        }

        $this->cart = $cartService->getCart();
        $this->totalAmount = $cartService->getTotalAmount();

        if (empty($this->cart)) {
            return redirect()->to('/')->with('warning', 'Giỏ hàng của bạn đang trống.');
        }

        // Tự động điền thông tin khách hàng từ tài khoản đăng nhập
        $user = auth()->user();
        $this->customer_name = $user->name;
        $this->customer_email = $user->email;
    }

    public function placeOrder(CartService $cartService)
    {
        $this->validate();

        try {
            // 1. Tạo mã đơn hàng duy nhất
            $orderCode = 'TSB-' . strtoupper(Str::random(8));

            // 2. Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,
                'customer_name' => $this->customer_name,
                'customer_phone' => $this->customer_phone,
                'customer_address' => $this->customer_address,
                'customer_email' => $this->customer_email,
                'total' => $this->totalAmount,
                'shipping_fee' => 0, // Miễn phí vận chuyển
                'payment_method' => $this->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending'
            ]);

            // 3. Tạo chi tiết đơn hàng & Ghi biến động kho
            $inventoryService = app(InventoryService::class);
            foreach ($this->cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    try {
                        $inventoryService->stockOut(
                            product: $product,
                            reason: 'sale',
                            quantity: $item['quantity'],
                            note: 'Đơn hàng #' . $orderCode,
                            referenceId: $order->id,
                            userId: null
                        );
                    } catch (\RuntimeException $e) {
                        // Tồn kho không đủ: vẫn cho đặt hàng nhưng không xuống âm
                        \Log::warning('Tồn kho không đủ khi đặt hàng', [
                            'product_id' => $product->id,
                            'order_id'   => $order->id,
                            'message'    => $e->getMessage(),
                        ]);
                    }
                }
            }

            // 4. Xóa giỏ hàng
            $cartService->clear();
            $this->dispatch('cartUpdated');

            $this->placedOrderCode = $orderCode;
            $this->orderPlaced = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Đã xảy ra lỗi trong quá trình đặt hàng. Vui lòng thử lại sau.');
            report($e);
        }
    }

    public function render()
    {
        return view('order::livewire.checkout')->layout('layouts.app');
    }
}
