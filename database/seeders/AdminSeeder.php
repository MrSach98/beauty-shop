<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@beautyshop.com'],
            [
                'name'      => 'Super Admin',
                'email'     => 'admin@beautyshop.com',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );
        echo "Admin created!\nEmail: admin@beautyshop.com\nPassword: admin123\n";
    }
}