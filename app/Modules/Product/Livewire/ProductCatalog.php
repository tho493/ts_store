<?php

namespace App\Modules\Product\Livewire;

use Livewire\Component;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\Category;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    // Các thuộc tính lọc (đồng bộ với Query String)
    public $category = '';
    public $search = '';
    public $brand = '';
    public $sort = 'newest';

    protected $queryString = [
        'category' => ['except' => ''],
        'search' => ['except' => ''],
        'brand' => ['except' => ''],
        'sort' => ['except' => 'newest']
    ];

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function selectCategory($slug)
    {
        $this->category = $slug;
        $this->resetPage();
    }

    public function selectBrand($brandName)
    {
        $this->brand = $brandName;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->category = '';
        $this->search = '';
        $this->brand = '';
        $this->sort = 'newest';
        $this->resetPage();
    }

    public function addToCart(int $productId)
    {
        // Gửi sự kiện để giỏ hàng xử lý
        $this->dispatch('addToCart', productId: $productId);
    }

    public function render()
    {
        $query = Product::active();

        // 1. Lọc theo tìm kiếm
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Lọc theo danh mục
        if (!empty($this->category)) {
            $categoryModel = Category::where('slug', $this->category)->first();
            if ($categoryModel) {
                $query->where('category_id', $categoryModel->id);
            }
        }

        // 3. Lọc theo hãng (Thương hiệu)
        if (!empty($this->brand)) {
            // specifications lưu dạng JSON, lọc theo key "Thương hiệu"
            $query->where('specifications->Thương hiệu', $this->brand);
        }

        // 4. Sắp xếp
        if ($this->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // Mới nhất
        }

        $products = $query->paginate(8);

        // Lấy danh sách danh mục để hiển thị sidebar
        $categoriesList = Category::all();

        // Lấy danh sách các thương hiệu độc nhất từ dữ liệu pin mẫu
        $brandsList = [
            'Panasonic',
            'Anker',
            'Dell',
            'Pisen',
            'TS Battery',
            'Samsung'
        ];

        return view('product::livewire.product-catalog', [
            'products' => $products,
            'categoriesList' => $categoriesList,
            'brandsList' => $brandsList
        ])->layout('layouts.app');
    }
}
