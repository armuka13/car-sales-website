<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@carsales.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        // Create site settings
        SiteSetting::create([
            'name' => 'FAHRZONE',
            'email' => 'example@fahrzone.com',
            'phone' => '+49 694 1423 4567',
            'whatsapp' => '+49 694 1423 4567',
        ]);
    }
}
