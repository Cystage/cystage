<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offres')->insert([
            'nom'         => 'Stage Développeur Web Full Stack',
            'ent_id'      => 3,
            'nb_week'     => 12,
            'week_hour'   => 35,
            'paye_hour'   => 4.05,
            'teletrav'    => 1,
            'poste_desc'  => 'Développement de nouvelles fonctionnalités sur notre plateforme SaaS en Laravel et Vue.js. Participation aux code reviews et aux cérémonies agile (sprint planning, daily, rétrospective).',
            'profil_desc' => 'Étudiant en informatique Bac+3/+5, curieux et autonome, avec des bases solides en PHP et JavaScript. Une expérience avec un framework MVC est un plus.',
        ]);
        DB::table('offres')->insert([
            'nom'         => 'Stage Data Analyst',
            'ent_id'      => 4,
            'nb_week'     => 8,
            'week_hour'   => 35,
            'paye_hour'   => 3.90,
            'teletrav'    => 0,
            'poste_desc'  => 'Analyse de données clients, création de dashboards et rapports automatisés. Travail avec Python et SQL sur des datasets volumineux. Visualisation avec Power BI.',
            'profil_desc' => 'Étudiant en data, statistiques ou informatique. Maîtrise de Python et SQL indispensable. Sens de l\'analyse et rigueur appréciés.',
        ]);
        DB::table('offres')->insert([
            'nom'         => 'Stage Cybersécurité',
            'ent_id'      => 5,
            'nb_week'     => 16,
            'week_hour'   => 35,
            'paye_hour'   => 4.50,
            'teletrav'    => 1,
            'poste_desc'  => 'Participation aux audits de sécurité, analyse des vulnérabilités, mise en place de politiques de sécurité et sensibilisation des équipes.',
            'profil_desc' => 'Étudiant en cybersécurité ou informatique avec des connaissances en réseaux et systèmes. Connaissance des outils type Wireshark, Metasploit appréciée.',
        ]);
        DB::table('offres')->insert([
            'nom'         => 'Stage Développeur Mobile',
            'ent_id'      => 3,
            'nb_week'     => 10,
            'week_hour'   => 35,
            'paye_hour'   => 4.20,
            'teletrav'    => 0,
            'poste_desc'  => 'Développement d\'une application mobile cross-platform avec Flutter. Intégration des APIs REST, gestion de l\'état et tests unitaires.',
            'profil_desc' => 'Étudiant en développement mobile ou informatique. Connaissances en Dart/Flutter ou React Native. Goût pour le design et l\'UX.',
        ]);

        DB::table('offres')->insert([
            'nom' => 'testOffreTele',
            'ent_id' => '1',
            'nb_week' => '6',
            'week_hour' => '35',
            'paye_hour' => '6.9',
            'teletrav' => '1',
            'poste_desc' => 'testPosteDesc',
            'profil_desc' => 'testProfilDesc',
        ]);
        DB::table('offres')->insert([
            'nom' => 'testOffrePasTele',
            'ent_id' => '2',
            'nb_week' => '6',
            'week_hour' => '35',
            'paye_hour' => '6.9',
            'teletrav' => '0',
            'poste_desc' => 'testPosteDesc',
            'profil_desc' => 'testProfilDesc',
        ]);
    }
}