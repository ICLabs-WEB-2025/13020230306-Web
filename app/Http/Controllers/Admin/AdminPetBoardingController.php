<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PetBoarding;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPetBoardingController extends Controller
{
    /**
     * Menampilkan daftar semua data penitipan untuk admin.
     */
    public function index(Request $request)
    {
        $query = PetBoarding::with('user')->orderBy('created_at', 'desc'); // Eager load relasi user

        // Fitur Filter (Opsional)
        if ($request->filled('status_filter') && $request->status_filter !== 'all') {
            $query->where('status', $request->status_filter);
        }
        if ($request->filled('search_filter')) {
            $searchTerm = $request->search_filter;
            $query->where(function($q) use ($searchTerm) {
                $q->where('pet_name', 'like', "%{$searchTerm}%")
                  ->orWhere('owner_name', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm){
                      $userQuery->where('email', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $boardings = $query->paginate(15); // Paginasi
        $statuses = [
            PetBoarding::STATUS_PENDING,
            PetBoarding::STATUS_VERIFIED,
            PetBoarding::STATUS_REJECTED,
            PetBoarding::STATUS_COMPLETED,
            PetBoarding::STATUS_CANCELLED,
        ];

        return view('admin.pet-boardings.index', compact('boardings', 'statuses'), ['title' => 'Kelola Penitipan Hewan']);
    }

    /**
     * Menampilkan detail satu data penitipan.
     */
    public function show(PetBoarding $petBoarding)
    {
        
        $petBoarding->load('user'); // Eager load user
        $statuses = [ 
            PetBoarding::STATUS_PENDING,
            PetBoarding::STATUS_VERIFIED,
            PetBoarding::STATUS_REJECTED,
            PetBoarding::STATUS_COMPLETED,
            PetBoarding::STATUS_CANCELLED,
        ];
        return view('admin.pet-boardings.show', compact('petBoarding', 'statuses'), ['title' => 'Detail Penitipan #' . $petBoarding->id]);
    }

    /**
     * Memperbarui status data penitipan oleh admin.
     */
    public function updateStatus(Request $request, PetBoarding $petBoarding)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in([
                PetBoarding::STATUS_PENDING,
                PetBoarding::STATUS_VERIFIED,
                PetBoarding::STATUS_REJECTED,
                PetBoarding::STATUS_COMPLETED,
                PetBoarding::STATUS_CANCELLED,
            ])],
            'admin_notes' => 'nullable|string', 
        ]);

        $petBoarding->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

  
        return redirect()->route('admin.pet-boardings.show', $petBoarding->id)->with('success', 'Status penitipan berhasil diperbarui.');
    }
}