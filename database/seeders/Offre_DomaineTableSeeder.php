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
        DB::table('offre__domaines')->insert([
            'offre_id' => '1',
            'dom_id' => '1',
        ]);
        DB::table('offre__domaines')->insert([
            'offre_id' => '1',
            'dom_id' => '5',
        ]);
        DB::table('offre__domaines')->insert([
            'offre_id' => '2',
            'dom_id' => '3',
        ]);
    }
}
