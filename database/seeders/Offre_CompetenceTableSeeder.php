<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Offre_CompetenceTableSeeder extends Seeder
{
    public function run(): void
    {
        // Compétences : Java=1, C=2, HTML/CSS=3, JavaScript=4, R=5,
        //               PHP=6, Data Mining=7, Python=8, SQL=9, Docker=10,
        //               Git=11, Flutter=12, React=13, Vue.js=14, Laravel=15

        $liens = [
            1  => [2, 8, 10, 11],       // Thales Cyber : C, Python, Docker, Git
            2  => [2, 1, 11],            // Dassault C++ : C, Java, Git
            3  => [6, 4, 3, 15, 14],     // Orange Full Stack : PHP, JS, HTML, Laravel, Vue.js
            4  => [8, 9, 5, 7],          // Orange Data : Python, SQL, R, Data Mining
            5  => [2, 1, 11],            // Airbus Embarqué : C, Java, Git
            6  => [10, 11, 8],           // Capgemini DevOps : Docker, Git, Python
            7  => [1, 9, 11],            // Capgemini Java : Java, SQL, Git
            8  => [4, 13, 9, 11],        // BNP FinTech : JS, React, SQL, Git
            9  => [8, 5, 7, 9],          // SocGen IA : Python, R, Data Mining, SQL
            10 => [8, 9, 5, 7],          // Safran Data : Python, SQL, R, Data Mining
            11 => [2, 1, 11],            // Ubisoft Jeux : C, Java, Git
            12 => [12, 4, 11],           // Ubisoft Mobile : Flutter, JS, Git
            13 => [8, 7, 9, 11],         // Criteo ML : Python, Data Mining, SQL, Git
            14 => [2, 11, 10],           // Thales Embarqué : C, Git, Docker
            15 => [8, 9, 7],             // Airbus Data : Python, SQL, Data Mining
        ];

        foreach ($liens as $offre_id => $skills) {
            foreach ($skills as $skill_id) {
                DB::table('offre__competences')->insert([
                    'offre_id' => $offre_id,
                    'skill_id' => $skill_id,
                ]);
            }
        }
    }
}
