<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Tambahkan ini
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Ke mana pengguna akan dialihkan setelah login.
     *
     * @var string
     */
    // protected $redirectTo = '/home'; // Kita akan menimpa ini

    /**
     * Buat instance kontroler baru.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Pengguna telah diautentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCustomer()) {
            return redirect()->route('customer.dashboard');
        }

        // Pengalihan default jika peran tidak cocok atau dasbor spesifik tidak diatur
        return redirect('/index'); // Atau ke halaman yang lebih sesuai
    }
}