<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $password = bcrypt('1234');

        // id=1 : Admin principal
        DB::table('users')->insert([
            'role_id'    => 1,
            'name'       => 'admin',
            'email'      => 'admin@cystage.online',
            'password'   => $password,
        ]);

        DB::table('users')->insert([
            'role_id'    => 1,
            'name'       => 'Dieudonne Fassi',
            'email'      => 'dieudonne.fassi@cyu.fr',
            'password'   => $password,
        ]);

        // id=2 à 11 : Entreprises
        $entreprises = [
            ['ent-Thales',    'contact@thalesgroup.com'],
            ['ent-Dassault',  'contact@dassault-aviation.com'],
            ['ent-Orange',    'contact@orange.com'],
            ['ent-Airbus',    'contact@airbus.com'],
            ['ent-Capgemini', 'contact@capgemini.com'],
            ['ent-BNP',       'contact@bnpparibas.com'],
            ['ent-SocGen',    'contact@societegenerale.com'],
            ['ent-Safran',    'contact@safran-group.com'],
            ['ent-Ubisoft',   'contact@ubisoft.com'],
            ['ent-Criteo',    'contact@criteo.com'],
        ];

        foreach ($entreprises as [$name, $email]) {
            DB::table('users')->insert([
                'role_id'  => 2,
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
            ]);
        }

        // id=12 à 21 : Étudiants
        $etudiants = [
            ['eABernard', 'antoine.bernard@etu.cyu.fr'],
            ['eLMartin',  'lea.martin@etu.cyu.fr'],
            ['eTDubois',  'thomas.dubois@etu.cyu.fr'],
            ['eCLefevre', 'camille.lefevre@etu.cyu.fr'],
            ['eHMoreau',  'hugo.moreau@etu.cyu.fr'],
            ['eEPetit',   'emma.petit@etu.cyu.fr'],
            ['eMSimon',   'maxime.simon@etu.cyu.fr'],
            ['eCRobert',  'chloe.robert@etu.cyu.fr'],
            ['eNDurand',  'nicolas.durand@etu.cyu.fr'],
            ['eIGarcia',  'ines.garcia@etu.cyu.fr'],
        ];

        foreach ($etudiants as [$name, $email]) {
            DB::table('users')->insert([
                'role_id'  => 3,
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
            ]);
        }
    }
}
