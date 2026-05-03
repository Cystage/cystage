<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffresTableSeeder extends Seeder
{
    public function run(): void
    {
        $offres = [
            // offre_id=1 — Thales (ent_id=1)
            [
                'nom'         => 'Stage Cybersécurité – Analyse de Vulnérabilités',
                'ent_id'      => 1,
                'nb_week'     => 16,
                'week_hour'   => 35,
                'paye_hour'   => 4.50,
                'teletrav'    => 1,
                'poste_desc'  => 'Au sein de la Direction Sécurité de Thales, vous participerez aux audits de sécurité de systèmes critiques (défense, aéronautique, spatial). Vous analyserez des vulnérabilités, rédigerez des rapports techniques et proposerez des contre-mesures. Vous interviendrez également sur des exercices de red team supervisés.',
                'profil_desc' => 'Étudiant Bac+4/+5 en cybersécurité ou informatique. Vous avez de bonnes bases en réseaux (TCP/IP, TLS), en systèmes Linux et en scripting (Python ou Bash). Une participation à des CTF ou à des projets de sécurité offensive est un vrai plus.',
            ],
            // offre_id=2 — Dassault Aviation (ent_id=2)
            [
                'nom'         => 'Stage Développeur Logiciel Embarqué C/C++',
                'ent_id'      => 2,
                'nb_week'     => 14,
                'week_hour'   => 35,
                'paye_hour'   => 4.35,
                'teletrav'    => 0,
                'poste_desc'  => 'Vous intégrerez l\'équipe en charge du développement des logiciels embarqués de nos avions d\'affaires. Vos missions : développement de composants temps réel en C/C++, intégration sur bancs de test, validation et rédaction de documentation technique selon les normes aéronautiques DO-178C.',
                'profil_desc' => 'Étudiant Bac+4/+5 en informatique ou systèmes embarqués. Maîtrise du C et C++ indispensable. La connaissance des systèmes temps réel (RTOS) ou des normes aéronautiques est appréciée. Rigueur et sens du détail sont essentiels dans ce contexte certifié.',
            ],
            // offre_id=3 — Orange (ent_id=3)
            [
                'nom'         => 'Stage Développeur Web Full Stack',
                'ent_id'      => 3,
                'nb_week'     => 12,
                'week_hour'   => 35,
                'paye_hour'   => 4.05,
                'teletrav'    => 1,
                'poste_desc'  => 'Vous rejoindrez l\'équipe produit d\'Orange pour développer de nouvelles fonctionnalités sur notre portail clients. Stack technique : Laravel (backend), Vue.js (frontend), PostgreSQL. Participation aux sprints agile, code reviews et présentations lors des démos bimensuelles.',
                'profil_desc' => 'Étudiant Bac+3/+5 en informatique. Vous maîtrisez PHP/Laravel et JavaScript/Vue.js. À l\'aise avec Git et les environnements de développement Unix. Curieux, autonome et capable de travailler en équipe distante.',
            ],
            // offre_id=4 — Orange (ent_id=3)
            [
                'nom'         => 'Stage Data Engineer – Pipelines de Données',
                'ent_id'      => 3,
                'nb_week'     => 10,
                'week_hour'   => 35,
                'paye_hour'   => 4.20,
                'teletrav'    => 1,
                'poste_desc'  => 'Vous construirez et optimiserez des pipelines de données pour notre plateforme d\'analytics interne. Vous travaillerez avec Python, Apache Spark et SQL sur des volumes de données importants. Vous produirez des dashboards avec Power BI pour les équipes métier.',
                'profil_desc' => 'Étudiant en data engineering, informatique ou statistiques. Maîtrise de Python et SQL requise. La connaissance de Spark, Airflow ou d\'un cloud provider (GCP, Azure) est un plus. Vous aimez résoudre des problèmes de performance sur de gros volumes.',
            ],
            // offre_id=5 — Airbus (ent_id=4)
            [
                'nom'         => 'Stage Ingénieur Systèmes Embarqués Avionique',
                'ent_id'      => 4,
                'nb_week'     => 16,
                'week_hour'   => 35,
                'paye_hour'   => 4.35,
                'teletrav'    => 0,
                'poste_desc'  => 'Intégré à l\'équipe avionique de Toulouse, vous développerez des modules logiciels embarqués pour les systèmes de navigation de l\'A320neo. Vous serez en charge de la conception, du codage en C, de l\'intégration sur plateforme matérielle et de la qualification selon RTCA/DO-178C.',
                'profil_desc' => 'Étudiant Bac+4/+5 en systèmes embarqués ou informatique. Solides connaissances en C et en architecture de systèmes temps réel. La maîtrise d\'un RTOS (VxWorks, FreeRTOS) est appréciée. Anglais technique courant nécessaire.',
            ],
            // offre_id=6 — Capgemini (ent_id=5)
            [
                'nom'         => 'Stage DevOps / Cloud – Automatisation CI/CD',
                'ent_id'      => 5,
                'nb_week'     => 14,
                'week_hour'   => 35,
                'paye_hour'   => 4.35,
                'teletrav'    => 1,
                'poste_desc'  => 'Vous interviendrez sur des projets clients grands comptes pour automatiser et industrialiser les chaînes de déploiement. Missions : mise en place de pipelines CI/CD GitLab, conteneurisation Docker, orchestration Kubernetes sur AWS. Vous contribuerez également à la supervision via Prometheus et Grafana.',
                'profil_desc' => 'Étudiant en informatique, réseaux ou DevOps. Connaissance de Docker et d\'un outil CI/CD (GitLab CI, Jenkins). Bases Linux solides. La pratique de Kubernetes ou Terraform est un vrai plus. Vous aimez automatiser et documenter.',
            ],
            // offre_id=7 — Capgemini (ent_id=5)
            [
                'nom'         => 'Stage Développeur Backend Java / Spring Boot',
                'ent_id'      => 5,
                'nb_week'     => 12,
                'week_hour'   => 35,
                'paye_hour'   => 4.05,
                'teletrav'    => 0,
                'poste_desc'  => 'Dans le cadre d\'une mission longue durée pour un client du secteur de l\'assurance, vous développerez des microservices Java Spring Boot. Vous concevrez des APIs REST, rédigerez des tests unitaires (JUnit) et d\'intégration, et participerez aux rituels agile (daily, planning, rétro).',
                'profil_desc' => 'Étudiant Bac+4/+5 en informatique. Maîtrise de Java et bonnes bases en conception objet. La connaissance de Spring Boot ou d\'une architecture microservices est attendue. SQL et Git maîtrisés. Rigoureux et soucieux de la qualité du code.',
            ],
            // offre_id=8 — BNP Paribas (ent_id=6)
            [
                'nom'         => 'Stage Développeur FinTech – Interface Bancaire',
                'ent_id'      => 6,
                'nb_week'     => 12,
                'week_hour'   => 35,
                'paye_hour'   => 4.05,
                'teletrav'    => 1,
                'poste_desc'  => 'Vous participerez au développement de l\'interface web de notre plateforme de paiement B2B. Stack : React (frontend), Node.js (backend), PostgreSQL. Vous implémenterez de nouvelles fonctionnalités conformes aux normes PSD2 et DSP2, et rédigerez les tests associés.',
                'profil_desc' => 'Étudiant Bac+3/+5 en informatique ou développement web. Maîtrise de JavaScript/React et de SQL. Sensibilité à la sécurité applicative appréciée (OWASP). Rigueur indispensable dans un contexte réglementé.',
            ],
            // offre_id=9 — Société Générale (ent_id=7)
            [
                'nom'         => 'Stage IA / Machine Learning – Modèles Prédictifs',
                'ent_id'      => 7,
                'nb_week'     => 16,
                'week_hour'   => 35,
                'paye_hour'   => 4.50,
                'teletrav'    => 1,
                'poste_desc'  => 'Au sein de la Direction Innovation de la Société Générale, vous développerez des modèles prédictifs pour détecter les anomalies dans les flux de transactions. Vous utiliserez Python, scikit-learn et TensorFlow. Vous présenterez vos résultats aux équipes métier lors de revues bimensuelles.',
                'profil_desc' => 'Étudiant Bac+4/+5 en data science, mathématiques appliquées ou informatique. Maîtrise de Python requise. Connaissance de scikit-learn, TensorFlow ou PyTorch appréciée. Bases solides en statistiques et algèbre linéaire.',
            ],
            // offre_id=10 — Safran (ent_id=8)
            [
                'nom'         => 'Stage Data Science – Maintenance Prédictive',
                'ent_id'      => 8,
                'nb_week'     => 14,
                'week_hour'   => 35,
                'paye_hour'   => 4.20,
                'teletrav'    => 0,
                'poste_desc'  => 'Dans le cadre du programme de maintenance prédictive de nos moteurs d\'avion, vous développerez des modèles d\'analyse de données capteurs (séries temporelles). Vous utiliserez Python, R et SQL. Vos analyses alimenteront directement les décisions de maintenance terrain.',
                'profil_desc' => 'Étudiant en data science, statistiques ou informatique. Python et R maîtrisés. Connaissance du traitement des séries temporelles ou du machine learning appréciée. Goût pour les problèmes industriels concrets.',
            ],
            // offre_id=11 — Ubisoft (ent_id=9)
            [
                'nom'         => 'Stage Développeur Gameplay – Jeux Vidéo',
                'ent_id'      => 9,
                'nb_week'     => 16,
                'week_hour'   => 35,
                'paye_hour'   => 4.50,
                'teletrav'    => 0,
                'poste_desc'  => 'Intégré à une équipe de développement sur un projet AAA, vous contribuerez au développement des mécaniques de gameplay en C++ sous Unreal Engine 5. Vous implémenterez des fonctionnalités, corriger des bugs et réaliserez des revues de code avec des ingénieurs seniors.',
                'profil_desc' => 'Étudiant en informatique ou développement de jeux vidéo. Solides bases en C++ orienté objet. Une expérience avec Unreal Engine ou Unity est fortement appréciée. Passionné par les jeux vidéo et curieux des défis techniques qu\'ils représentent.',
            ],
            // offre_id=12 — Ubisoft (ent_id=9)
            [
                'nom'         => 'Stage Développeur Mobile – Application Companion',
                'ent_id'      => 9,
                'nb_week'     => 10,
                'week_hour'   => 35,
                'paye_hour'   => 4.05,
                'teletrav'    => 1,
                'poste_desc'  => 'Vous développerez une application mobile companion (iOS/Android) pour l\'un de nos jeux phares. Vous utiliserez Flutter et consommerez nos APIs REST internes. Vous travaillerez en étroite collaboration avec les équipes design et QA.',
                'profil_desc' => 'Étudiant en développement mobile ou informatique. Maîtrise de Flutter/Dart ou React Native. Sens du détail UX/UI. À l\'aise avec les appels API REST et la gestion d\'état.',
            ],
            // offre_id=13 — Criteo (ent_id=10)
            [
                'nom'         => 'Stage Machine Learning – Systèmes de Recommandation',
                'ent_id'      => 10,
                'nb_week'     => 12,
                'week_hour'   => 35,
                'paye_hour'   => 4.35,
                'teletrav'    => 1,
                'poste_desc'  => 'Au cœur du moteur de recommandation publicitaire de Criteo, vous améliorerez les algorithmes de ranking et de ciblage. Vous travaillerez sur des pipelines de données massifs avec Python et Spark. Vos modèles seront déployés en production et mesurés en A/B test.',
                'profil_desc' => 'Étudiant Bac+5 en data science ou machine learning. Python avancé requis. Connaissance des algorithmes de recommandation (collaborative filtering, LTR). Expérience avec Spark ou des frameworks de ML (XGBoost, LightGBM) appréciée.',
            ],
            // offre_id=14 — Thales (ent_id=1)
            [
                'nom'         => 'Stage Développeur Systèmes Embarqués Temps Réel',
                'ent_id'      => 1,
                'nb_week'     => 14,
                'week_hour'   => 35,
                'paye_hour'   => 4.20,
                'teletrav'    => 0,
                'poste_desc'  => 'Vous contribuerez au développement de logiciels embarqués pour des systèmes de communication sécurisés (domaine défense). Vos missions : développement bas niveau en C, intégration sur cibles matérielles ARM, débogage avec JTAG, et rédaction de spécifications.',
                'profil_desc' => 'Étudiant en systèmes embarqués ou informatique. Bonne maîtrise du C, notions d\'assembleur et d\'architecture processeur. La connaissance des protocoles de communication série (UART, SPI, I2C) est un plus. Habilitation de sécurité possible selon profil.',
            ],
            // offre_id=15 — Airbus (ent_id=4)
            [
                'nom'         => 'Stage Data Analyst – Optimisation Industrielle',
                'ent_id'      => 4,
                'nb_week'     => 12,
                'week_hour'   => 35,
                'paye_hour'   => 4.05,
                'teletrav'    => 1,
                'poste_desc'  => 'Vous analyserez les données de production des lignes d\'assemblage de l\'A350 pour identifier des axes d\'optimisation. Vous produirez des tableaux de bord interactifs avec Power BI et Python. Vous présenterez vos conclusions aux équipes opérationnelles chaque semaine.',
                'profil_desc' => 'Étudiant en data, statistiques ou informatique. Maîtrise de Python et SQL. Expérience avec Power BI ou Tableau appréciée. Capacité à vulgariser des analyses complexes à un public non technique.',
            ],
        ];

        foreach ($offres as $offre) {
            DB::table('offres')->insert($offre);
        }
    }
}
