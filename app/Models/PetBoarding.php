<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBoarding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pet_name',
        'owner_name',
        'pet_type',
        'pet_age',
        'service_package',
        'payment_method',
        'total_cost',
        'payment_proof_path',
        'status',
        'admin_notes',
    ];

    /**
     * Relasi ke model User (pemilik).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Anda bisa menambahkan konstanta untuk status agar lebih mudah dikelola
    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    // Helper untuk mengecek apakah bisa diedit/dibatalkan
    public function canBeModified()
    {
        return $this->status === self::STATUS_PENDING;
    }
}