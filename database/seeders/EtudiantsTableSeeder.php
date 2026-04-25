<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtudiantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etudiants')->insert([
            'user_id' => '3',
            'prenom' => 'Test',
            'nom' => 'Etu',
            'num_etudiant' => '66666666',
        ]);

        DB::table('etudiants')->insert([
            'user_id'      => 6,
            'prenom'       => 'Jean',
            'nom'          => 'Dupont',
            'num_etudiant' => '22101234',
        ]);
        DB::table('etudiants')->insert([
            'user_id'      => 9,
            'prenom'       => 'Léa',
            'nom'          => 'Martin',
            'num_etudiant' => '22105678',
        ]);
    }
}