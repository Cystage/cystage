<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $isMySQL = DB::connection()->getDriverName() === 'mysql';

        if ($isMySQL) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        foreach ([
            'postulation_commentaires', 'postulations',
            'offre__domaines', 'offre__competences', 'offres',
            'etudiants', 'entreprises', 'users',
            'competences', 'domaines', 'roles',
        ] as $table) {
            DB::table($table)->truncate();
        }

        if ($isMySQL) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            EntreprisesTableSeeder::class,
            EtudiantsTableSeeder::class,
            OffresTableSeeder::class,
            CompetencesTableSeeder::class,
            DomainesTableSeeder::class,
            Offre_CompetenceTableSeeder::class,
            Offre_DomaineTableSeeder::class,
            PostulationsTableSeeder::class,
            PostulationCommentairesTableSeeder::class,
        ]);
    }
}
