<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expenses_types')->insert([
            [
                'name'       => 'Quotidien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Hebdomadaire',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
