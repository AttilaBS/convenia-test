<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function run(): void
    {
        User::withoutEvents(function () {
            return User::query()->updateOrCreate([
                'name' => 'Manager',
                'email' => 'manager@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
            ]);
        });
    }
}
