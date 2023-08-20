<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Get the current year
        $currentYear = $currentDate->year -1;
        $endYear = 2053;

        while ($currentYear <= $endYear) {
            $fromDate = $currentYear . '-08-031';
            $toDate = ($currentYear + 1) . '-08-31';

            DB::table('school_years')->insert([
                'name' => $currentYear . '/' . ($currentYear + 1),
                'from' => $fromDate,
                'to' => $toDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $currentYear++;
        }
    }
}
