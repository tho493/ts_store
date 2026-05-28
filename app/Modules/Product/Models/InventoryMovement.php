<?php

namespace App\Modules\Product\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'reason',
        'quantity',
        'quantity_before',
        'quantity_after',
        'note',
        'reference_id',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
        'reference_id' => 'integer',
    ];

    // Labels cho hiển thị
    public const TYPE_LABELS = [
        'in'         => 'Nhập kho',
        'out'        => 'Xuất kho',
        'adjustment' => 'Điều chỉnh',
    ];

    public const REASON_LABELS = [
        'purchase'          => 'Nhập hàng mới',
        'sale'              => 'Đơn hàng bán',
        'return'            => 'Hoàn hàng / Hủy đơn',
        'damage'            => 'Hàng hỏng / Mất',
        'manual_adjustment' => 'Điều chỉnh kiểm kê',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy label hiển thị cho type
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }

    /**
     * Lấy label hiển thị cho reason
     */
    public function getReasonLabelAttribute(): string
    {
        return self::REASON_LABELS[$this->reason] ?? $this->reason;
    }

    /**
     * Số lượng hiển thị với dấu +/-
     */
    public function getSignedQuantityAttribute(): string
    {
        return match($this->type) {
            'in'  => '+' . $this->quantity,
            'out' => '-' . $this->quantity,
            'adjustment' => ($this->quantity_after >= $this->quantity_before ? '+' : '') . ($this->quantity_after - $this->quantity_before),
            default => (string)$this->quantity,
        };
    }
}
