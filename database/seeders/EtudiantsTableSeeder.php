<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtudiantsTableSeeder extends Seeder
{
    public function run(): void
    {
        $etudiants = [
            // etu_id=1
            ['user_id' => 13, 'prenom' => 'Antoine',  'nom' => 'Bernard',  'num_etudiant' => '22100001'],
            // etu_id=2
            ['user_id' => 14, 'prenom' => 'Léa',      'nom' => 'Martin',   'num_etudiant' => '22100002'],
            // etu_id=3
            ['user_id' => 15, 'prenom' => 'Thomas',   'nom' => 'Dubois',   'num_etudiant' => '22100003'],
            // etu_id=4
            ['user_id' => 16, 'prenom' => 'Camille',  'nom' => 'Lefèvre',  'num_etudiant' => '22100004'],
            // etu_id=5
            ['user_id' => 17, 'prenom' => 'Hugo',     'nom' => 'Moreau',   'num_etudiant' => '22100005'],
            // etu_id=6
            ['user_id' => 18, 'prenom' => 'Emma',     'nom' => 'Petit',    'num_etudiant' => '22100006'],
            // etu_id=7
            ['user_id' => 19, 'prenom' => 'Maxime',   'nom' => 'Simon',    'num_etudiant' => '22100007'],
            // etu_id=8
            ['user_id' => 20, 'prenom' => 'Chloé',    'nom' => 'Robert',   'num_etudiant' => '22100008'],
            // etu_id=9
            ['user_id' => 21, 'prenom' => 'Nicolas',  'nom' => 'Durand',   'num_etudiant' => '22100009'],
            // etu_id=10
            ['user_id' => 22, 'prenom' => 'Inès',     'nom' => 'Garcia',   'num_etudiant' => '22100010'],
        ];

        foreach ($etudiants as $etu) {
            DB::table('etudiants')->insert($etu);
        }
    }
}
