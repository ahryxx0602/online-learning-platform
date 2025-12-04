<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Đường chuyển hướng khi người dùng chưa đăng nhập.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Nếu là request API thì trả về JSON (null để AuthenticationException tự xử lý)
        if ($request->expectsJson()) {
            return null;
        }

        // Các URL admin
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('login'); // login admin
        }

        // Dùng route login trong module Auth
        return route('login'); // tương ứng route('login') ở Modules/Auth/routes/web.php
    }
}
