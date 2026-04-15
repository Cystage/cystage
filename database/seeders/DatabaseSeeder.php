<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EntreprisesTableSeeder::class);
        $this->call(EtudiantsTableSeeder::class);
        $this->call(OffresTableSeeder::class);
        $this->call(CompetencesTableSeeder::class);
        $this->call(DomainesTableSeeder::class);
        $this->call(Offre_CompetenceTableSeeder::class);
        $this->call(Offre_DomaineTableSeeder::class);
    }
}
