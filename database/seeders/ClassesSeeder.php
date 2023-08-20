<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('classes')->insert([
            [
                'name'       => 'Tronc Commun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => '1ère Bac',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => '2ème Bac',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
