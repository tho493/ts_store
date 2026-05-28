<?php

namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Product\Models\Product;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderItem;
use App\Modules\Core\Models\Setting;
use App\Modules\Product\Models\Category;
use App\Modules\User\Models\User;
use App\Modules\Product\Services\InventoryService;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Giao diện đăng nhập Admin
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('core::admin.login');
    }

    /**
     * Xử lý đăng nhập Admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:6'
        ]);

        // Kiểm tra xem input là Email hay Username (Name)
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->back()->withInput($request->only('login'))->withErrors([
                    'login' => 'Tài khoản của bạn đã bị khóa hoặc tạm ngừng hoạt động.'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Chào mừng bạn quay trở lại hệ thống quản trị.');
        }

        return redirect()->back()->withInput($request->only('login'))->withErrors([
            'login' => 'Thông tin đăng nhập không chính xác hoặc tài khoản không tồn tại.'
        ]);
    }

    /**
     * Đăng xuất Admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Bạn đã đăng xuất tài khoản quản trị thành công.');
    }

    /**
     * Dashboard & Cấu hình hệ thống
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $revenue = Order::where('payment_status', 'paid')
            ->orWhere('status', 'completed')
            ->sum('total');

        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return view('core::admin.dashboard', compact('totalProducts', 'totalOrders', 'revenue', 'lowStockProducts'));
    }

    /**
     * Cập nhật cấu hình bật/tắt giỏ hàng, hotline...
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'hotline' => 'required',
            'zalo_link' => 'required|url',
            'messenger_link' => 'required|url',
            'address' => 'required'
        ]);

        Setting::updateOrCreate(
            ['key' => 'enable_shopping_cart'],
            ['value' => $request->has('enable_shopping_cart') ? '1' : '0']
        );

        Setting::updateOrCreate(['key' => 'hotline'], ['value' => $request->hotline]);
        Setting::updateOrCreate(['key' => 'zalo_link'], ['value' => $request->zalo_link]);
        Setting::updateOrCreate(['key' => 'messenger_link'], ['value' => $request->messenger_link]);
        Setting::updateOrCreate(['key' => 'address'], ['value' => $request->address]);

        return redirect()->back()->with('success', 'Đã cập nhật cấu hình hệ thống thành công.');
    }

    /**
     * Danh sách sản phẩm pin
     */
    public function products()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(10);
        return view('core::admin.products', compact('products'));
    }

    /**
     * Giao diện thêm sản phẩm mới
     */
    public function createProduct()
    {
        $categories = Category::all();
        return view('core::admin.products.create', compact('categories'));
    }

    /**
     * Lưu sản phẩm mới
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|unique:products,name',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $specs = [];
        if ($request->has('spec_keys')) {
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key) && isset($request->spec_values[$index])) {
                    $specs[$key] = $request->spec_values[$index];
                }
            }
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $thumbnailPath = $image->store('products', 'public');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => strtoupper($request->sku),
            'price' => $request->price,
            'sale_price' => $request->sale_price ?: null,
            'stock' => $request->stock,
            'description' => $request->description,
            'specifications' => $specs,
            'thumbnail' => $thumbnailPath,
            'status' => $request->has('status')
        ]);

        // Lưu album ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Đã thêm sản phẩm mới thành công.');
    }

    /**
     * Giao diện sửa sản phẩm
     */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('core::admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Lưu thông tin sửa đổi sản phẩm
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|min:5|unique:products,name,' . $product->id,
            'sku' => 'required|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $specs = [];
        if ($request->has('spec_keys')) {
            foreach ($request->spec_keys as $index => $key) {
                if (!empty($key) && isset($request->spec_values[$index])) {
                    $specs[$key] = $request->spec_values[$index];
                }
            }
        }

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => strtoupper($request->sku),
            'price' => $request->price,
            'sale_price' => $request->sale_price ?: null,
            'stock' => $request->stock,
            'description' => $request->description,
            'specifications' => $specs,
            'status' => $request->has('status')
        ];

        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh đại diện cũ
            if ($product->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->thumbnail);
            }
            
            $image = $request->file('thumbnail');
            $data['thumbnail'] = $image->store('products', 'public');
        }

        $product->update($data);

        // Lưu thêm ảnh phụ mới
        if ($request->hasFile('images')) {
            $currentMaxSort = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $currentMaxSort + 1 + $index
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Đã cập nhật sản phẩm thành công.');
    }

    /**
     * Cập nhật nhanh giá và tồn kho từ danh sách
     */
    public function quickUpdateProduct(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'price' => $request->price,
            'sale_price' => $request->sale_price ?: null,
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Đã cập nhật nhanh sản phẩm thành công.');
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Đã xóa sản phẩm thành công.');
    }

    /**
     * Quản lý Danh mục (Hiển thị danh sách & Form thêm)
     */
    public function categories()
    {
        $categories = Category::with('products')->orderBy('name', 'asc')->get();
        return view('core::admin.categories.index', compact('categories'));
    }

    /**
     * Lưu danh mục mới
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Đã tạo danh mục mới thành công.');
    }

    /**
     * Xóa danh mục
     */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Đã xóa danh mục thành công.');
    }

    /**
     * Danh sách đơn hàng
     */
    public function orders()
    {
        $orders = Order::with('items.product')->orderBy('created_at', 'desc')->paginate(10);
        return view('core::admin.orders', compact('orders'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status'         => 'required|in:pending,confirmed,shipping,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        $order = Order::with('items.product')->findOrFail($id);
        $previousStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status'         => $newStatus,
            'payment_status' => $request->payment_status,
        ]);

        // Hoàn kho tự động khi Admin hủy đơn (chỉ hoàn 1 lần)
        if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
            $inventoryService = app(InventoryService::class);
            foreach ($order->items as $item) {
                if ($item->product) {
                    try {
                        $inventoryService->stockIn(
                            product: $item->product,
                            reason: 'return',
                            quantity: $item->quantity,
                            note: 'Hủy đơn hàng #' . $order->order_code,
                            referenceId: $order->id,
                            userId: Auth::id()
                        );
                    } catch (\Throwable $e) {
                        \Log::error('Lỗi hoàn kho khi hủy đơn', [
                            'order_id'   => $order->id,
                            'product_id' => $item->product_id,
                            'message'    => $e->getMessage(),
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $order->order_code . ' thành công.');
    }

    /**
     * Danh sách tài khoản người dùng
     */
    public function users(Request $request)
    {
        $search = $request->input('search');
        $query = User::orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10)->withQueryString();
        return view('core::admin.users', compact('users', 'search'));
    }

    /**
     * Giao diện thêm tài khoản mới
     */
    public function createUser()
    {
        return view('core::admin.users.create');
    }

    /**
     * Lưu tài khoản mới
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,customer',
            'status' => 'required|in:active,inactive'
        ], [
            'name.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.unique' => 'Địa chỉ email đã được đăng ký.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => $request->status
        ]);

        return redirect()->route('admin.users')->with('success', 'Đã tạo tài khoản mới thành công.');
    }

    /**
     * Giao diện chỉnh sửa tài khoản
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('core::admin.users.edit', compact('user'));
    }

    /**
     * Lưu cập nhật tài khoản
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:users,name,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,customer',
            'status' => 'required|in:active,inactive'
        ], [
            'name.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.unique' => 'Địa chỉ email đã được đăng ký.'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Chỉ cho phép cập nhật vai trò và trạng thái nếu không tự sửa chính mình
        if ($user->id !== Auth::id()) {
            $data['role'] = $request->role;
            $data['status'] = $request->status;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Đã cập nhật thông tin tài khoản thành công.');
    }

    /**
     * Bật/tắt trạng thái hoạt động của tài khoản
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $msg = $newStatus === 'active' ? 'Đã kích hoạt tài khoản thành công.' : 'Đã khóa tài khoản thành công.';
        return redirect()->route('admin.users')->with('success', $msg);
    }

    /**
     * Xóa tài khoản khách hàng
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Không cho phép tự xóa chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Đã xóa tài khoản người dùng thành công.');
    }

    /**
     * Xóa ảnh phụ của sản phẩm
     */
    public function deleteProductImage($id)
    {
        $image = \App\Modules\Product\Models\ProductImage::findOrFail($id);
        
        // Xóa tệp vật lý trong storage
        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
        
        $image->delete();
        
        return redirect()->back()->with('success', 'Đã xóa ảnh phụ thành công.');
    }
}
