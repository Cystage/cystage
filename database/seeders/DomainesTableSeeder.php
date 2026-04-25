<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domaines = [
            'Développement Web', 'Cybersécurité', 'Data Science',
            'Systèmes Embarqués', 'Développement Logiciel',
            'Mobile', 'DevOps', 'Intelligence Artificielle',
        ];
        foreach ($domaines as $d) {
            DB::table('domaines')->insert(['name' => $d]);
        }
    }
}
