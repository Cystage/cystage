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
        // Offre 1 - Dev Web : PHP, JavaScript, Laravel, HTML/CSS
        foreach ([6, 4, 15, 3] as $skill_id) {
            DB::table('offre__competences')->insert(['offre_id' => 1, 'skill_id' => $skill_id]);
        }
        // Offre 2 - Data : Python, SQL, R, Data Mining
        foreach ([8, 9, 5, 7] as $skill_id) {
            DB::table('offre__competences')->insert(['offre_id' => 2, 'skill_id' => $skill_id]);
        }
        // Offre 3 - Cyber : Docker, Git, C
        foreach ([10, 11, 2] as $skill_id) {
            DB::table('offre__competences')->insert(['offre_id' => 3, 'skill_id' => $skill_id]);
        }
        // Offre 4 - Mobile : Flutter, JavaScript, Git
        foreach ([12, 4, 11] as $skill_id) {
            DB::table('offre__competences')->insert(['offre_id' => 4, 'skill_id' => $skill_id]);
        }

        DB::table('offre__competences')->insert([
            'offre_id' => '5',
            'skill_id' => '3',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '5',
            'skill_id' => '4',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '5',
            'skill_id' => '6',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '6',
            'skill_id' => '5',
        ]);
        DB::table('offre__competences')->insert([
            'offre_id' => '6',
            'skill_id' => '7',
        ]);
    }
}
