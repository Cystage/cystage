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
        $token = 'pk_FrA0KHUJRGyvwsX08nZ1ow';

        DB::table('entreprises')->insert([
            'user_id'     => 2,
            'nom'         => 'testEnt',
            'siret'       => 'test',
            'adresse'     => 'testAdr',
            'code_postal' => '01234',
            'ville'       => 'testVille',
            'pays'        => 'testPays',
            'num_tel'     => '6666666666',
            'logo'        => null,
        ]);
        DB::table('entreprises')->insert([
            'user_id'     => 3,
            'nom'         => 'testEnt2',
            'siret'       => 'test',
            'adresse'     => 'testAdr',
            'code_postal' => '01234',
            'ville'       => 'testVille',
            'pays'        => 'testPays',
            'num_tel'     => '6666666666',
            'logo'        => null,
        ]);
        DB::table('entreprises')->insert([
            'user_id'     => 5,
            'nom'         => 'Total',
            'siret'       => '12345678901234',
            'adresse'     => '12 rue de la Paix',
            'code_postal' => '75001',
            'ville'       => 'Paris',
            'pays'        => 'France',
            'num_tel'     => '0612345678',
            'logo'        => "https://img.logo.dev/totalenergies.com?token={$token}",
        ]);
        DB::table('entreprises')->insert([
            'user_id'     => 7,
            'nom'         => 'Safran',
            'siret'       => '98765432109876',
            'adresse'     => '5 avenue du Numérique',
            'code_postal' => '64000',
            'ville'       => 'Pau',
            'pays'        => 'France',
            'num_tel'     => '0598765432',
            'logo'        => "https://img.logo.dev/safran-group.com?token={$token}",
        ]);
        DB::table('entreprises')->insert([
            'user_id'     => 8,
            'nom'         => 'Airbus',
            'siret'       => '56789012345678',
            'adresse'     => '1 boulevard de l aviation',
            'code_postal' => '31000',
            'ville'       => 'Toulouse',
            'pays'        => 'France',
            'num_tel'     => '0567890123',
            'logo'        => "https://img.logo.dev/airbus.com?token={$token}",
        ]);
    }
}
