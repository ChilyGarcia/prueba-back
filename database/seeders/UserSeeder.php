<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->upsert(
            [
                'id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => env('ADMIN_EMAIL'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'phone_number' => '+573001234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ['id'],
            ['first_name', 'last_name', 'email', 'password', 'phone_number', 'updated_at'],
        );
    }
}
