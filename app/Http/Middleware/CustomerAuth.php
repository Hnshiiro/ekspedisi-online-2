<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login sebagai pelanggan terlebih dahulu.');
        }
        return $next($request);
    }
}
