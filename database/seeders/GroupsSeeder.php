<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'name'       => 'Group 1',
                'class_id'   => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Group1',
                'class_id'   => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Group 1',
                'class_id'   => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Group 2',
                'class_id'   => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}