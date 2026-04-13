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
    }
}