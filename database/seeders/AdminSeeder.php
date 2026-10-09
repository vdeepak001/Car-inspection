<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the admin account used to open the dashboard.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@lotbook.test'],
            [
                'name' => 'Lotbook Admin',
                'phone' => '5550100100',
                'password' => 'password',
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
