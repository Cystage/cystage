<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('753159'),
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'TestEnt',
            'email' => 'entreprise@example.com',
            'password' => bcrypt('2222'),
        ]);
        DB::table('users')->insert([
            'role_id' => '3',
            'name' => 'TestEtu',
            'email' => 'etudiant@example.com',
            'password' => bcrypt('3333'),
        ]);
        DB::table('offres')->insert([
            'nom' => 'testOffre',
            'entreprise' => 'testEnt',
            'adresse' => 'testAdr',
            'description' => 'testDesc',
        ]);
    }
}
