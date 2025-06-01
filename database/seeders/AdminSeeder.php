<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), // Kata sandi: admin123
            'role' => 'admin', // Menandai sebagai admin
        ]);
    }
}