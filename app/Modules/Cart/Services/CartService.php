<?php

namespace App\Modules\Cart\Services;

use App\Modules\Product\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'ts_cart';

    /**
     * Lấy toàn bộ giỏ hàng
     */
    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Thêm sản phẩm vào giỏ
     */
    public function add(int $productId, int $quantity = 1): array
    {
        $cart = $this->getCart();
        $product = Product::active()->find($productId);

        if (!$product) {
            return $cart;
        }

        $price = $product->final_price;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => (float)$price,
                'thumbnail' => $product->thumbnail,
                'quantity' => $quantity
            ];
        }

        Session::put($this->sessionKey, $cart);
        return $cart;
    }

    /**
     * Cập nhật số lượng
     */
    public function updateQuantity(int $productId, int $quantity): array
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            Session::put($this->sessionKey, $cart);
        }

        return $cart;
    }

    /**
     * Xóa sản phẩm khỏi giỏ
     */
    public function remove(int $productId): array
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put($this->sessionKey, $cart);
        }

        return $cart;
    }

    /**
     * Tính tổng số lượng item trong giỏ
     */
    public function getTotalQuantity(): int
    {
        $cart = $this->getCart();
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Tính tổng số tiền trong giỏ
     */
    public function getTotalAmount(): float
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Xóa toàn bộ giỏ
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
