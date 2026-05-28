<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'price',
        'sale_price',
        'stock',
        'thumbnail',
        'description',
        'content',
        'specifications',
        'status'
    ];

    protected $casts = [
        'specifications' => 'array',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class)->latest();
    }

    /**
     * Scope hiển thị sản phẩm đang bán
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Lấy giá hiển thị cuối cùng (sau khi trừ khuyến mãi)
     */
    public function getFinalPriceAttribute()
    {
        return $this->sale_price !== null ? $this->sale_price : $this->price;
    }
}
