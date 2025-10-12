<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ranee Alleyda',
            'email' => 'ranee@r.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
        ]);
    }
}
