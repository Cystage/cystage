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
            'nom' => 'testOffre',
            'ent_id' => '1',
            'nb_week' => '6',
            'week_hour' => '35',
            'paye_hour' => '6.9',
            'teletrav' => 'true',
            'poste_desc' => 'testPosteDesc',
            'profil_desc' => 'testProfilDesc',
        ]);
    }
}