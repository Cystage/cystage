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
            'name' => 'admin',
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
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'TestEnt2',
            'email' => 'entreprise2@example.com',
            'password' => bcrypt('4444'),
        ]);

        DB::table('users')->insert([
            'role_id'  => 2,
            'name'     => 'ent-Total',
            'email'    => 'contact@total.fr',
            'password' => bcrypt('1234'),
        ]);
        DB::table('users')->insert([
            'role_id'  => 3,
            'name'     => 'eJDupont',
            'email'    => 'jean.dupont@etu.cyu.fr',
            'password' => bcrypt('1234'),
        ]);
        DB::table('users')->insert([
            'role_id'  => 2,
            'name'     => 'ent-Safran',
            'email'    => 'contact@safran.fr',
            'password' => bcrypt('1234'),
        ]);
        DB::table('users')->insert([
            'role_id'  => 2,
            'name'     => 'ent-Airbus',
            'email'    => 'contact@airbus.fr',
            'password' => bcrypt('1234'),
        ]);
        DB::table('users')->insert([
            'role_id'  => 3,
            'name'     => 'eLMartin',
            'email'    => 'lea.martin@etu.cyu.fr',
            'password' => bcrypt('1234'),
        ]);
    }
}
