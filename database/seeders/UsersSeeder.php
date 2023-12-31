<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the 'users' table with sample data
        DB::table('users')->insert([
            'name'              => 'samira',
            'email'             => 'samira@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('smith123finance'),
            'role'              => 'finance',
        ]);

        // Seed the 'users' table with sample data
        DB::table('users')->insert([
            'name'              => 'majida',
            'email'             => 'majida@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('smith123gestion'),
            'role'              => 'gestion',
        ]);
    }
}