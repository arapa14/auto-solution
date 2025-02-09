<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login
        if (!Auth::check()) {
            // Set flash message untuk notifikasi login terlebih dahulu
            session()->flash('error', 'Silakan login terlebih dahulu untuk membeli produk.');
            // Redirect ke halaman landing (atau halaman login, sesuai kebutuhan)
            return redirect()->route('landing');
        }

        return $next($request);
    }
}
