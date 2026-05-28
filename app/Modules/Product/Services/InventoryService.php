<?php

namespace App\Modules\Product\Services;

use App\Modules\Product\Models\InventoryMovement;
use App\Modules\Product\Models\Product;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class InventoryService
{
    /**
     * Ghi nhận một biến động tồn kho vào hệ thống.
     *
     * @param  Product    $product
     * @param  string     $type       in | out | adjustment
     * @param  string     $reason     purchase | sale | return | damage | manual_adjustment
     * @param  int        $quantity   Số lượng (luôn dương)
     * @param  string|null $note      Ghi chú
     * @param  int|null   $referenceId ID đơn hàng liên quan
     * @param  int|null   $userId     ID admin thực hiện (null = hệ thống tự động)
     * @return InventoryMovement
     */
    public function recordMovement(
        Product $product,
        string $type,
        string $reason,
        int $quantity,
        ?string $note = null,
        ?int $referenceId = null,
        ?int $userId = null
    ): InventoryMovement {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Số lượng phải lớn hơn 0.');
        }

        if (!in_array($type, ['in', 'out', 'adjustment'])) {
            throw new InvalidArgumentException("Loại biến động không hợp lệ: {$type}");
        }

        return DB::transaction(function () use ($product, $type, $reason, $quantity, $note, $referenceId, $userId) {
            // Lock dòng sản phẩm để tránh race condition
            $product = Product::lockForUpdate()->find($product->id);

            $quantityBefore = $product->stock;

            $quantityAfter = match($type) {
                'in'  => $quantityBefore + $quantity,
                'out' => $quantityBefore - $quantity,
                'adjustment' => $quantity, // Điều chỉnh về đúng số thực tế
            };

            if ($quantityAfter < 0) {
                throw new RuntimeException("Tồn kho không đủ. Hiện có: {$quantityBefore}, yêu cầu xuất: {$quantity}.");
            }

            // Cập nhật tồn kho sản phẩm
            $product->update(['stock' => $quantityAfter]);

            // Ghi lịch sử biến động
            return InventoryMovement::create([
                'product_id'      => $product->id,
                'type'            => $type,
                'reason'          => $reason,
                'quantity'        => $quantity,
                'quantity_before' => $quantityBefore,
                'quantity_after'  => $quantityAfter,
                'note'            => $note,
                'reference_id'    => $referenceId,
                'user_id'         => $userId,
            ]);
        });
    }

    /**
     * Nhập kho (shortcut)
     */
    public function stockIn(Product $product, string $reason, int $quantity, ?string $note = null, ?int $referenceId = null, ?int $userId = null): InventoryMovement
    {
        return $this->recordMovement($product, 'in', $reason, $quantity, $note, $referenceId, $userId);
    }

    /**
     * Xuất kho (shortcut)
     */
    public function stockOut(Product $product, string $reason, int $quantity, ?string $note = null, ?int $referenceId = null, ?int $userId = null): InventoryMovement
    {
        return $this->recordMovement($product, 'out', $reason, $quantity, $note, $referenceId, $userId);
    }

    /**
     * Điều chỉnh về số thực tế (kiểm kê)
     */
    public function adjustment(Product $product, int $actualQty, ?string $note = null, ?int $userId = null): InventoryMovement
    {
        $currentStock = $product->fresh()->stock;
        $delta = abs($actualQty - $currentStock);

        // Khi adjustment, quantity lưu là số lượng tuyệt đối thực tế
        return DB::transaction(function () use ($product, $actualQty, $note, $userId, $currentStock) {
            $product = Product::lockForUpdate()->find($product->id);
            $quantityBefore = $product->stock;

            if ($actualQty < 0) {
                throw new InvalidArgumentException('Số lượng tồn kho không thể âm.');
            }

            $product->update(['stock' => $actualQty]);

            return InventoryMovement::create([
                'product_id'      => $product->id,
                'type'            => 'adjustment',
                'reason'          => 'manual_adjustment',
                'quantity'        => abs($actualQty - $quantityBefore),
                'quantity_before' => $quantityBefore,
                'quantity_after'  => $actualQty,
                'note'            => $note,
                'reference_id'    => null,
                'user_id'         => $userId,
            ]);
        });
    }
}
