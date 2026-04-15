<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Offre_CompetenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offre__competences')->insert([
            'offre_id' => '1',
            'skill_id' => '3',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '1',
            'skill_id' => '4',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '1',
            'skill_id' => '6',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '2',
            'skill_id' => '5',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '2',
            'skill_id' => '7',
        ]);
    }
}
