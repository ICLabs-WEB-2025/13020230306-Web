<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Tangani permintaan yang masuk.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) { // Jika belum login
            return redirect('login');
        }

        $user = Auth::user();
        if ($user->role == $role) {
            return $next($request);
        }

        // Jika peran tidak cocok, alihkan atau batalkan
        // Anda dapat mengalihkan ke dasbor umum atau beranda, atau menampilkan pesan error
        // Untuk kesederhanaan, kita alihkan ke beranda dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        // Atau batalkan: abort(403, 'Aksi tidak diizinkan.');
    }
}