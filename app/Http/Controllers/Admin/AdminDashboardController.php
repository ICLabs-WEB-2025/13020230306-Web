<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PetBoarding;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $adminName = Auth::user()->name;

        $totalPengguna = User::where('role', 'customer')->count();

        $totalPendapatan = PetBoarding::where('status', PetBoarding::STATUS_COMPLETED)
                                ->sum('total_cost');

        return view('admin.dashboard', [
            'adminName' => $adminName,
            'totalPengguna' => $totalPengguna,
            'totalPendapatan' => $totalPendapatan,
            'title' => 'Dasbor Utama Admin'
        ]);
    }
}
