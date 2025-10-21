<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RBACSeeder::class
        ]);

        $user = User::create([
            'username' => 'admin',
            'password' => Hash::make('12345'),
            'ho_ten' => 'Administrator',
            'is_active' => true
        ]);
        $user->assignRole('super-admin');
    }
}
