<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offres')->insert([
            'nom' => 'testOffreTele',
            'ent_id' => '1',
            'nb_week' => '6',
            'week_hour' => '35',
            'paye_hour' => '6.9',
            'teletrav' => '1',
            'poste_desc' => 'testPosteDesc',
            'profil_desc' => 'testProfilDesc',
        ]);
        DB::table('offres')->insert([
            'nom' => 'testOffrePasTele',
            'ent_id' => '2',
            'nb_week' => '6',
            'week_hour' => '35',
            'paye_hour' => '6.9',
            'teletrav' => '0',
            'poste_desc' => 'testPosteDesc',
            'profil_desc' => 'testProfilDesc',
        ]);
    }
}