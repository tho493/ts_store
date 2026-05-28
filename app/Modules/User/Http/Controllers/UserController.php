<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\User\Models\User;
use App\Modules\Order\Models\Order;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Giao diện đăng nhập khách hàng
     */
    public function showLoginForm()
    {
        return view('user::login');
    }

    /**
     * Xử lý đăng nhập khách hàng
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

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
            
            // Nếu trong giỏ hàng có sản phẩm, redirect sang checkout, ngược lại về home
            $cart = session()->get('ts_cart', []);
            if (!empty($cart) && setting('enable_shopping_cart', true)) {
                return redirect()->route('checkout');
            }

            return redirect()->route('home')->with('success', 'Đăng nhập thành công.');
        }

        return redirect()->back()->withInput($request->only('login'))->withErrors([
            'login' => 'Thông tin đăng nhập không chính xác.'
        ]);
    }

    /**
     * Giao diện đăng ký khách hàng
     */
    public function showRegisterForm()
    {
        return view('user::register');
    }

    /**
     * Xử lý đăng ký khách hàng
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.unique' => 'Địa chỉ email đã được đăng ký.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Redirect phù hợp
        $cart = session()->get('ts_cart', []);
        if (!empty($cart) && setting('enable_shopping_cart', true)) {
            return redirect()->route('checkout');
        }

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công.');
    }

    /**
     * Đăng xuất khách hàng
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đã đăng xuất tài khoản.');
    }

    /**
     * Lịch sử đơn hàng của khách hàng
     */
    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user::my-orders', compact('orders'));
    }
}
