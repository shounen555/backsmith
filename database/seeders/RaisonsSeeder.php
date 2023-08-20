<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaisonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('raisons')->insert([
            [
                'name'       => 'location',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Fonctionnaires',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'CNSS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Taxes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Assurance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Professeurs',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Photocopie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Redal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Télécom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}