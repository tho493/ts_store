<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['in', 'out', 'adjustment'])->comment('in=nhập, out=xuất, adjustment=điều chỉnh');
            $table->string('reason')->comment('purchase|sale|return|damage|manual_adjustment');
            $table->unsignedInteger('quantity')->comment('Số lượng (luôn dương)');
            $table->integer('quantity_before')->comment('Tồn kho trước biến động');
            $table->integer('quantity_after')->comment('Tồn kho sau biến động');
            $table->text('note')->nullable()->comment('Ghi chú thêm');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('ID đơn hàng liên quan');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
