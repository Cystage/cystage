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
        DB::table('offres')->insert([
            'nom'         => 'Stage DevOps / Cloud',
            'ent_id'      => 6,
            'nb_week'     => 14,
            'week_hour'   => 35,
            'paye_hour'   => 4.35,
            'teletrav'    => 1,
            'poste_desc'  => 'Intégration et déploiement continu sur des infrastructures cloud (AWS/Azure). Automatisation des pipelines CI/CD avec GitLab, gestion des conteneurs Docker et orchestration Kubernetes. Participation aux astreintes et à la supervision des environnements de production.',
            'profil_desc' => 'Étudiant en informatique ou systèmes réseaux, avec des bases en Linux et scripting. Une expérience avec Docker ou un outil CI/CD est appréciée. Vous êtes rigoureux, curieux et aimez automatiser.',
        ]);
        DB::table('offres')->insert([
            'nom'         => 'Stage Développeur Backend Java',
            'ent_id'      => 7,
            'nb_week'     => 12,
            'week_hour'   => 35,
            'paye_hour'   => 4.05,
            'teletrav'    => 0,
            'poste_desc'  => 'Développement de microservices en Java Spring Boot pour nos systèmes bancaires. Participation à la conception des APIs REST, rédaction de tests unitaires et d\'intégration. Travail en équipe agile dans un contexte financier réglementé.',
            'profil_desc' => 'Étudiant Bac+4/+5 en informatique, avec de bonnes bases en Java. La connaissance de Spring Boot ou d\'une architecture microservices est un atout. Rigueur et sens du détail obligatoires.',
        ]);
        DB::table('offres')->insert([
            'nom'         => 'Stage IA / Machine Learning',
            'ent_id'      => 4,
            'nb_week'     => 16,
            'week_hour'   => 35,
            'paye_hour'   => 4.20,
            'teletrav'    => 1,
            'poste_desc'  => 'Conception et entraînement de modèles de machine learning pour l\'optimisation de processus industriels. Utilisation de Python, TensorFlow et de pipelines de données MLOps. Présentation des résultats à l\'équipe R&D.',
            'profil_desc' => 'Étudiant en data science, mathématiques appliquées ou informatique. Maîtrise de Python et des bases en algèbre linéaire / statistiques. Connaissance de scikit-learn ou TensorFlow appréciée.',
        ]);
    }
}