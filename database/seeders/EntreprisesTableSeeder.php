<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntreprisesTableSeeder extends Seeder
{
    public function run(): void
    {
        $token = 'pk_FrA0KHUJRGyvwsX08nZ1ow';

        // user_id décalé de 1 car id=2 est réservé au compte prof admin
        $entreprises = [
            // ent_id=1
            [
                'user_id'     => 3,
                'nom'         => 'Thales',
                'siret'       => '32032641800044',
                'adresse'     => '4 avenue des Louvresses',
                'code_postal' => '92622',
                'ville'       => 'Gennevilliers',
                'pays'        => 'France',
                'num_tel'     => '0157773000',
                'logo'        => "https://img.logo.dev/thalesgroup.com?token={$token}",
            ],
            // ent_id=2
            [
                'user_id'     => 4,
                'nom'         => 'Dassault Aviation',
                'siret'       => '71204453000014',
                'adresse'     => '9 rond-point des Champs-Élysées',
                'code_postal' => '75008',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0147117000',
                'logo'        => "https://img.logo.dev/dassault-aviation.com?token={$token}",
            ],
            // ent_id=3
            [
                'user_id'     => 5,
                'nom'         => 'Orange',
                'siret'       => '38012986622736',
                'adresse'     => '78 rue Olivier de Serres',
                'code_postal' => '75015',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0900800700',
                'logo'        => "https://img.logo.dev/orange.com?token={$token}",
            ],
            // ent_id=4
            [
                'user_id'     => 6,
                'nom'         => 'Airbus',
                'siret'       => '56789012345678',
                'adresse'     => '1 rond-point Maurice Bellonte',
                'code_postal' => '31700',
                'ville'       => 'Blagnac',
                'pays'        => 'France',
                'num_tel'     => '0561937500',
                'logo'        => "https://img.logo.dev/airbus.com?token={$token}",
            ],
            // ent_id=5
            [
                'user_id'     => 7,
                'nom'         => 'Capgemini',
                'siret'       => '34987654321098',
                'adresse'     => '11 rue de Tilsitt',
                'code_postal' => '75017',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0142378500',
                'logo'        => "https://img.logo.dev/capgemini.com?token={$token}",
            ],
            // ent_id=6
            [
                'user_id'     => 8,
                'nom'         => 'BNP Paribas',
                'siret'       => '66265832600017',
                'adresse'     => '16 boulevard des Italiens',
                'code_postal' => '75009',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0140148000',
                'logo'        => "https://img.logo.dev/bnpparibas.com?token={$token}",
            ],
            // ent_id=7
            [
                'user_id'     => 9,
                'nom'         => 'Société Générale',
                'siret'       => '55203060037130',
                'adresse'     => '29 boulevard Haussmann',
                'code_postal' => '75009',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0142146000',
                'logo'        => "https://img.logo.dev/societegenerale.com?token={$token}",
            ],
            // ent_id=8
            [
                'user_id'     => 10,
                'nom'         => 'Safran',
                'siret'       => '98765432109876',
                'adresse'     => '2 boulevard du Général Martial Valin',
                'code_postal' => '75724',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0140607000',
                'logo'        => "https://img.logo.dev/safran-group.com?token={$token}",
            ],
            // ent_id=9
            [
                'user_id'     => 11,
                'nom'         => 'Ubisoft',
                'siret'       => '33454301600036',
                'adresse'     => '28 rue Armand Carrel',
                'code_postal' => '93108',
                'ville'       => 'Montreuil',
                'pays'        => 'France',
                'num_tel'     => '0148586000',
                'logo'        => "https://img.logo.dev/ubisoft.com?token={$token}",
            ],
            // ent_id=10
            [
                'user_id'     => 12,
                'nom'         => 'Criteo',
                'siret'       => '48433476400011',
                'adresse'     => '32 rue Blanche',
                'code_postal' => '75009',
                'ville'       => 'Paris',
                'pays'        => 'France',
                'num_tel'     => '0175849900',
                'logo'        => "https://img.logo.dev/criteo.com?token={$token}",
            ],
        ];

        foreach ($entreprises as $ent) {
            DB::table('entreprises')->insert($ent);
        }
    }
}
