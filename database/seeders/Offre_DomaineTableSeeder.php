<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Offre_DomaineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('offre__domaines')->insert(['offre_id' => 1, 'dom_id' => 1]); // Dev Web
        DB::table('offre__domaines')->insert(['offre_id' => 1, 'dom_id' => 5]); // Dev Logiciel
        DB::table('offre__domaines')->insert(['offre_id' => 2, 'dom_id' => 3]); // Data Science
        DB::table('offre__domaines')->insert(['offre_id' => 2, 'dom_id' => 8]); // IA
        DB::table('offre__domaines')->insert(['offre_id' => 3, 'dom_id' => 2]); // Cyber
        DB::table('offre__domaines')->insert(['offre_id' => 3, 'dom_id' => 7]); // DevOps
        DB::table('offre__domaines')->insert(['offre_id' => 4, 'dom_id' => 6]); // Mobile

        DB::table('offre__domaines')->insert([
            'offre_id' => '5',
            'dom_id' => '1',
        ]);
        DB::table('offre__domaines')->insert([
            'offre_id' => '5',
            'dom_id' => '5',
        ]);
        DB::table('offre__domaines')->insert([
            'offre_id' => '6',
            'dom_id' => '3',
        ]);
    }
}
