<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntreprisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entreprises')->insert([
            'user_id' => '2',
            'nom' => 'testEnt',
            'siret' => 'test',
            'adresse' => 'testAdr',
            'code_postal' => '01234',
            'ville' => 'testVille',
            'pays' => 'testPays',
        ]);
    }
}
