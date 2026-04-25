<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competences = [
            'Java', 'C', 'HTML/CSS', 'JavaScript', 'R',
            'PHP', 'Data Mining', 'Python', 'SQL', 'Docker',
            'Git', 'Flutter', 'React', 'Vue.js', 'Laravel',
        ];
        foreach ($competences as $c) {
            DB::table('competences')->insert(['name' => $c]);
        }
    }
}
