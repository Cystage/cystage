<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Offre_DomaineTableSeeder extends Seeder
{
    public function run(): void
    {
        // Domaines : Développement Web=1, Cybersécurité=2, Data Science=3,
        //            Systèmes Embarqués=4, Développement Logiciel=5, Mobile=6, DevOps=7, IA=8

        $liens = [
            1  => [2, 7],    // Thales Cyber : Cybersécurité, DevOps
            2  => [5, 4],    // Dassault : Dev Logiciel, Systèmes Embarqués
            3  => [1, 5],    // Orange Full Stack : Dev Web, Dev Logiciel
            4  => [3, 8],    // Orange Data : Data Science, IA
            5  => [4, 5],    // Airbus Embarqué : Systèmes Embarqués, Dev Logiciel
            6  => [7, 5],    // Capgemini DevOps : DevOps, Dev Logiciel
            7  => [5, 1],    // Capgemini Java : Dev Logiciel, Dev Web
            8  => [1, 5],    // BNP FinTech : Dev Web, Dev Logiciel
            9  => [8, 3],    // SocGen IA : IA, Data Science
            10 => [3, 8],    // Safran Data : Data Science, IA
            11 => [5],       // Ubisoft Jeux : Dev Logiciel
            12 => [6, 5],    // Ubisoft Mobile : Mobile, Dev Logiciel
            13 => [8, 3],    // Criteo ML : IA, Data Science
            14 => [4, 2],    // Thales Embarqué : Systèmes Embarqués, Cybersécurité
            15 => [3, 8],    // Airbus Data : Data Science, IA
        ];

        foreach ($liens as $offre_id => $domaines) {
            foreach ($domaines as $dom_id) {
                DB::table('offre__domaines')->insert([
                    'offre_id' => $offre_id,
                    'dom_id'   => $dom_id,
                ]);
            }
        }
    }
}
