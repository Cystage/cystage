<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostulationsTableSeeder extends Seeder
{
    public function run(): void
    {
        // state: 1=en attente, 2=acceptée, 3=confirmée (stage en cours)

        $postulations = [
            // id=1 — Antoine (etu=1) → Orange Full Stack (offre=3) — confirmée
            [
                'offre_id' => 3, 'etu_id' => 1, 'state' => 3, 'path' => '',
                'motiv' => 'Passionné par le développement web, j\'ai travaillé sur plusieurs projets Laravel et Vue.js en cours. Rejoindre Orange serait une opportunité unique de contribuer à des projets à grande échelle dans un environnement agile structuré.',
            ],
            // id=2 — Antoine (etu=1) → Capgemini DevOps (offre=6) — en attente
            [
                'offre_id' => 6, 'etu_id' => 1, 'state' => 1, 'path' => '',
                'motiv' => 'L\'automatisation et le cloud m\'attirent depuis que j\'ai mis en place un pipeline GitLab CI/CD pour mon projet de fin d\'année. Ce stage chez Capgemini me permettrait de franchir une étape supplémentaire avec Kubernetes et AWS.',
            ],
            // id=3 — Léa (etu=2) → Thales Cybersécurité (offre=1) — acceptée
            [
                'offre_id' => 1, 'etu_id' => 2, 'state' => 2, 'path' => '',
                'motiv' => 'La cybersécurité est ma voie depuis deux ans. J\'ai participé à plusieurs CTF classés et mené des audits réseau en formation. Intégrer Thales, acteur de référence dans les systèmes critiques, correspond exactement à mes ambitions professionnelles.',
            ],
            // id=4 — Léa (etu=2) → Société Générale IA (offre=9) — en attente
            [
                'offre_id' => 9, 'etu_id' => 2, 'state' => 1, 'path' => '',
                'motiv' => 'L\'application de l\'IA à la détection de fraude bancaire m\'intéresse beaucoup. J\'ai réalisé un projet de classification avec scikit-learn et je souhaite approfondir cela dans un contexte industriel exigeant comme celui de la Société Générale.',
            ],
            // id=5 — Thomas (etu=3) → BNP FinTech (offre=8) — acceptée
            [
                'offre_id' => 8, 'etu_id' => 3, 'state' => 2, 'path' => '',
                'motiv' => 'Développer des interfaces pour le secteur bancaire dans un contexte réglementé (PSD2) est un défi qui me motive. Je maîtrise React et Node.js et j\'ai une sensibilité particulière à la sécurité applicative que j\'ai développée en cours.',
            ],
            // id=6 — Thomas (etu=3) → Orange Full Stack (offre=3) — en attente
            [
                'offre_id' => 3, 'etu_id' => 3, 'state' => 1, 'path' => '',
                'motiv' => 'Orange est un acteur technologique majeur et ce stage full stack correspond à mon projet professionnel. Je suis à l\'aise avec Laravel et Vue.js, et j\'aimerais découvrir comment ces outils sont utilisés à l\'échelle d\'un opérateur national.',
            ],
            // id=7 — Camille (etu=4) → Capgemini Java (offre=7) — confirmée
            [
                'offre_id' => 7, 'etu_id' => 4, 'state' => 3, 'path' => '',
                'motiv' => 'Java et l\'architecture microservices sont au cœur de ma spécialisation. J\'ai déjà conçu une API REST avec Spring Boot pour un projet académique. Travailler chez Capgemini sur un vrai projet client serait la meilleure façon de consolider mes compétences.',
            ],
            // id=8 — Camille (etu=4) → Orange Data (offre=4) — en attente
            [
                'offre_id' => 4, 'etu_id' => 4, 'state' => 1, 'path' => '',
                'motiv' => 'Le data engineering m\'attire depuis que j\'ai travaillé sur un projet de pipeline de données avec Python et Airflow. Ce stage chez Orange me permettrait de monter en compétence sur Spark et les architectures Big Data.',
            ],
            // id=9 — Hugo (etu=5) → Airbus Systèmes Embarqués (offre=5) — acceptée
            [
                'offre_id' => 5, 'etu_id' => 5, 'state' => 2, 'path' => '',
                'motiv' => 'Les systèmes embarqués avioniques sont ma passion depuis ma découverte du développement bas niveau. Je maîtrise le C et j\'ai travaillé avec FreeRTOS sur des projets personnels. Participer à l\'avionique de l\'A320neo serait une expérience extraordinaire.',
            ],
            // id=10 — Hugo (etu=5) → Thales Embarqué (offre=14) — en attente
            [
                'offre_id' => 14, 'etu_id' => 5, 'state' => 1, 'path' => '',
                'motiv' => 'Le développement embarqué temps réel pour des systèmes de défense m\'intéresse. J\'ai de l\'expérience en programmation bas niveau (C, protocoles série) et je suis motivé par les contraintes de fiabilité extrêmes que Thales impose à ses logiciels.',
            ],
            // id=11 — Emma (etu=6) → Société Générale IA (offre=9) — confirmée
            [
                'offre_id' => 9, 'etu_id' => 6, 'state' => 3, 'path' => '',
                'motiv' => 'Spécialisée en machine learning, j\'ai développé plusieurs modèles de détection d\'anomalies avec TensorFlow lors de mon master. Travailler sur des flux de transactions bancaires réels chez la Société Générale est exactement le type de défi que je recherche.',
            ],
            // id=12 — Emma (etu=6) → Safran Data (offre=10) — en attente
            [
                'offre_id' => 10, 'etu_id' => 6, 'state' => 1, 'path' => '',
                'motiv' => 'L\'analyse de données capteurs pour la maintenance prédictive est un sujet qui me fascine. J\'ai réalisé un projet de classification de séries temporelles en Python/R dans le cadre de mon master et je souhaite l\'appliquer à un contexte industriel réel.',
            ],
            // id=13 — Maxime (etu=7) → Ubisoft Jeux (offre=11) — en attente
            [
                'offre_id' => 11, 'etu_id' => 7, 'state' => 1, 'path' => '',
                'motiv' => 'Développeur de jeux indie depuis mes 16 ans, je maîtrise Unreal Engine 5 et le C++ avancé. Rejoindre Ubisoft pour contribuer à un projet AAA serait l\'aboutissement de ma formation. Je suis prêt à relever les défis techniques d\'un studio de cette envergure.',
            ],
            // id=14 — Maxime (etu=7) → Dassault (offre=2) — en attente
            [
                'offre_id' => 2, 'etu_id' => 7, 'state' => 1, 'path' => '',
                'motiv' => 'Le développement logiciel embarqué certifié m\'attire par sa rigueur. Mes solides bases en C++ et mon intérêt pour les systèmes contraints me semblent correspondre aux exigences du développement avionique chez Dassault Aviation.',
            ],
            // id=15 — Chloé (etu=8) → Ubisoft Mobile (offre=12) — acceptée
            [
                'offre_id' => 12, 'etu_id' => 8, 'state' => 2, 'path' => '',
                'motiv' => 'Le développement mobile cross-platform avec Flutter est ma spécialité. J\'ai publié deux applications sur le Play Store développées en Dart. Contribuer à une application companion pour un jeu Ubisoft serait une expérience unique à la frontière du gaming et du mobile.',
            ],
            // id=16 — Chloé (etu=8) → Criteo ML (offre=13) — en attente
            [
                'offre_id' => 13, 'etu_id' => 8, 'state' => 1, 'path' => '',
                'motiv' => 'Les systèmes de recommandation m\'intéressent depuis que j\'ai implémenté un moteur de filtrage collaboratif dans un projet académique. Travailler sur des modèles déployés en production à l\'échelle de Criteo serait une expérience formatrice.',
            ],
            // id=17 — Nicolas (etu=9) → Airbus Data (offre=15) — en attente
            [
                'offre_id' => 15, 'etu_id' => 9, 'state' => 1, 'path' => '',
                'motiv' => 'L\'optimisation de lignes d\'assemblage aéronautique par la donnée est un sujet concret et impactant. Je maîtrise Python, SQL et Power BI et j\'aimerais appliquer ces compétences à des données industrielles réelles chez Airbus.',
            ],
            // id=18 — Nicolas (etu=9) → Safran Data (offre=10) — en attente
            [
                'offre_id' => 10, 'etu_id' => 9, 'state' => 1, 'path' => '',
                'motiv' => 'La maintenance prédictive par analyse de données capteurs est un domaine en plein essor. Mes compétences en Python et en traitement de séries temporelles, acquises lors de mon projet de M1, me semblent bien adaptées aux besoins de Safran.',
            ],
            // id=19 — Inès (etu=10) → Criteo ML (offre=13) — confirmée
            [
                'offre_id' => 13, 'etu_id' => 10, 'state' => 3, 'path' => '',
                'motiv' => 'Le machine learning appliqué à la recommandation publicitaire est un domaine que j\'explore depuis ma 3ème année. J\'ai de l\'expérience avec XGBoost et LightGBM sur des jeux de données Kaggle, et je suis enthousiaste à l\'idée de travailler sur des modèles en production chez Criteo.',
            ],
            // id=20 — Inès (etu=10) → Société Générale IA (offre=9) — en attente
            [
                'offre_id' => 9, 'etu_id' => 10, 'state' => 1, 'path' => '',
                'motiv' => 'La détection d\'anomalies dans des flux financiers avec du deep learning est un sujet sur lequel j\'ai réalisé un projet de recherche. Ce stage chez la Société Générale serait l\'occasion de passer de la recherche à l\'application industrielle.',
            ],
        ];

        foreach ($postulations as $p) {
            DB::table('postulations')->insert($p);
        }
    }
}
