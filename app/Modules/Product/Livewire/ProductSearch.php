<?php

namespace App\Modules\Product\Livewire;

use Livewire\Component;
use App\Modules\Product\Models\Product;

class ProductSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $this->results = Product::active()
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->query . '%')
                  ->orWhere('sku', 'like', '%' . $this->query . '%')
                  ->orWhere('description', 'like', '%' . $this->query . '%');
            })
            ->take(5)
            ->get();
    }

    public function search()
    {
        if (!empty($this->query)) {
            return redirect()->to('/?search=' . urlencode($this->query));
        }
    }

    public function render()
    {
        return view('product::livewire.product-search');
    }
}
