<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('competences')->insert([
            'name' => 'Java',
        ]);
        DB::table('competences')->insert([
            'name' => 'C',
        ]);
        DB::table('competences')->insert([
            'name' => 'Html',
        ]);
        DB::table('competences')->insert([
            'name' => 'Javascript',
        ]);
        DB::table('competences')->insert([
            'name' => 'R',
        ]);
        DB::table('competences')->insert([
            'name' => 'Php',
        ]);
        DB::table('competences')->insert([
            'name' => 'Data mining',
        ]);
    }
}
