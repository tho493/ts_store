<?php

namespace App\Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Models\InventoryMovement;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Danh sách tất cả biến động kho
     */
    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        $type      = $request->input('type');
        $dateFrom  = $request->input('date_from');
        $dateTo    = $request->input('date_to');

        $query = InventoryMovement::with(['product', 'user'])->latest();

        if ($productId) {
            $query->where('product_id', $productId);
        }
        if ($type && in_array($type, ['in', 'out', 'adjustment'])) {
            $query->where('type', $type);
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $movements = $query->paginate(30)->withQueryString();
        $products  = Product::orderBy('name')->get(['id', 'name', 'sku']);

        return view('product::admin.inventory.index', compact('movements', 'products', 'productId', 'type', 'dateFrom', 'dateTo'));
    }

    /**
     * Lịch sử biến động kho theo 1 sản phẩm
     */
    public function byProduct(int $id)
    {
        $product   = Product::findOrFail($id);
        $movements = InventoryMovement::with('user')
            ->where('product_id', $id)
            ->latest()
            ->paginate(20);

        $totalIn  = InventoryMovement::where('product_id', $id)->where('type', 'in')->sum('quantity');
        $totalOut = InventoryMovement::where('product_id', $id)->where('type', 'out')->sum('quantity');

        return view('product::admin.inventory.product', compact('product', 'movements', 'totalIn', 'totalOut'));
    }

    /**
     * Form điều chỉnh kho thủ công
     */
    public function createAdjustment(int $id)
    {
        $product = Product::findOrFail($id);
        return view('product::admin.inventory.adjust', compact('product'));
    }

    /**
     * Lưu điều chỉnh kho thủ công
     */
    public function storeAdjustment(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'type'     => 'required|in:in,out,adjustment',
            'reason'   => 'required|in:purchase,return,damage,manual_adjustment',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:500',
        ], [
            'quantity.min' => 'Số lượng phải ít nhất là 1.',
        ]);

        $inventoryService = app(InventoryService::class);

        try {
            if ($request->type === 'adjustment') {
                // Điều chỉnh về số thực tế kiểm kê
                $inventoryService->adjustment(
                    product: $product,
                    actualQty: $request->integer('quantity'),
                    note: $request->input('note'),
                    userId: Auth::id()
                );
            } else {
                $inventoryService->recordMovement(
                    product: $product,
                    type: $request->type,
                    reason: $request->reason,
                    quantity: $request->integer('quantity'),
                    note: $request->input('note'),
                    referenceId: null,
                    userId: Auth::id()
                );
            }
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.inventory.product', $id)
            ->with('success', 'Đã điều chỉnh tồn kho thành công.');
    }
}
