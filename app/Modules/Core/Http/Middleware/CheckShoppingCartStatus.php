<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckShoppingCartStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!setting('enable_shopping_cart', true)) {
            return redirect()->route('home')->with('warning', 'Chức năng giỏ hàng và thanh toán trực tuyến hiện đang tạm tắt. Vui lòng liên hệ trực tiếp với chúng tôi để mua hàng.');
        }

        return $next($request);
    }
}
