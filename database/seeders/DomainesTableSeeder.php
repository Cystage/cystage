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
        DB::table('domaines')->insert([
            'name' => 'DevWeb',
        ]);
        DB::table('domaines')->insert([
            'name' => 'Cyber',
        ]);
        DB::table('domaines')->insert([
            'name' => 'Data',
        ]);
        DB::table('domaines')->insert([
            'name' => 'Embarqué',
        ]);
        DB::table('domaines')->insert([
            'name' => 'Dev',
        ]);
    }
}
