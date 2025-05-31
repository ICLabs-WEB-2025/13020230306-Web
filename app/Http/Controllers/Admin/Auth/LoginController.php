<?php

namespace App\Http\Controllers\Admin\Auth; // Pastikan namespace ini benar

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider; // Untuk pengalihan setelah login
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // Untuk menangani login gagal

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Ke mana pengguna akan dialihkan setelah login admin.
     * Ini bisa dioverride oleh konstanta ADMIN_HOME di RouteServiceProvider.
     *
     * @var string
     */
    // protected $redirectTo = '/admin/dashboard'; // Bisa dihapus jika menggunakan redirectTo()

    /**
     * Buat instance kontroler baru.
     *
     * @return void
     */
    public function __construct()
    {
        // Menggunakan middleware 'guest' dengan guard 'admin'.
        // Ini memastikan admin yang sudah login tidak bisa mengakses halaman login admin lagi,
        // kecuali untuk metode 'logout'.
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Menampilkan formulir login admin.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Pastikan path view ini benar
    }

    /**
     * Menentukan guard yang akan digunakan untuk autentikasi admin.
     * Ini menimpa metode default dari trait AuthenticatesUsers.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin'); // Menggunakan guard 'admin' yang telah dikonfigurasi
    }

    /**
     * Mengambil kredensial yang akan digunakan untuk mencoba login.
     * Di sini kita menambahkan syarat bahwa 'role' harus 'admin'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        // Tambahkan kondisi 'role' => 'admin' ke kredensial.
        // Ini PENTING agar customer tidak bisa login melalui form admin
        // meskipun email & password mereka benar untuk guard 'web'.
        $credentials['role'] = 'admin';
        return $credentials;
    }

    /**
     * Dipanggil setelah pengguna admin berhasil diautentikasi.
     * Anda bisa menambahkan logika tambahan di sini jika perlu.
     * Misalnya, memastikan lagi peran pengguna (meskipun sudah difilter di credentials).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Pengecekan peran tambahan (opsional, karena sudah ada di credentials())
        // Jika model User Anda memiliki metode isAdmin()
        if (!$user->isAdmin()) { // Atau if ($user->role !== 'admin')
            $this->guard()->logout(); // Logout dari guard 'admin'
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect($this->loginPath()) // Menggunakan loginPath() untuk fleksibilitas
                ->withErrors([$this->username() => 'Akun ini tidak memiliki hak akses admin.']);
        }

        // Jika lolos, biarkan Laravel mengarahkan ke $this->redirectPath()
        // yang akan menggunakan $redirectTo atau redirectTo() atau ADMIN_HOME.
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Mendapatkan path ke mana pengguna akan dialihkan setelah login.
     * Ini akan menggunakan konstanta ADMIN_HOME dari RouteServiceProvider.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        // Menggunakan konstanta dari RouteServiceProvider untuk pengalihan admin
        // return property_exists($this, 'redirectTo') ? $this->redirectTo : RouteServiceProvider::ADMIN_HOME;
    }


    /**
     * Menangani permintaan logout untuk admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout(); // Logout dari guard 'admin'

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        // Arahkan kembali ke halaman login admin setelah logout
        // return $request->wantsJson()
        //     ? new JsonResponse([], 204)
        //     : redirect($this->loginPath()); // Menggunakan loginPath() agar lebih fleksibel
    }

    /**
     * Mendapatkan path ke formulir login.
     *
     * @return string
     */
    public function loginPath()
    {
        // Sesuaikan dengan nama rute login admin Anda jika berbeda
        return route('admin.login');
    }

    /**
     * Menangani respons login yang gagal.
     * Ini dimodifikasi agar pesan error lebih sesuai untuk admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed_admin')], // Pesan error kustom
        ])->redirectTo($this->loginPath()); // Kembali ke form login admin
    }
}   