<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostulationsTableSeeder extends Seeder
{
    public function run(): void
    {
        // state: 1=en attente, 2=acceptée, 3=confirmée (stage en cours)

        // Jean Dupont (etu 2) → Dev Web Full Stack chez Total (offre 1) — confirmée
        DB::table('postulations')->insert([
            'offre_id' => 1,
            'etu_id'   => 2,
            'state'    => 3,
            'motiv'    => 'Passionné par le développement web, je souhaite mettre en pratique mes compétences en Laravel et Vue.js acquises lors de mes projets universitaires. Votre environnement agile et vos projets SaaS m\'attirent particulièrement.',
            'path'     => '',
        ]);

        // Jean Dupont (etu 2) → Data Analyst chez Safran (offre 2) — en attente
        DB::table('postulations')->insert([
            'offre_id' => 2,
            'etu_id'   => 2,
            'state'    => 1,
            'motiv'    => 'Très intéressé par l\'analyse de données, j\'ai travaillé avec Python et SQL lors de plusieurs projets académiques. Ce stage chez Safran serait une opportunité idéale pour approfondir mes connaissances en data engineering.',
            'path'     => '',
        ]);

        // Léa Martin (etu 3) → Cybersécurité chez Airbus (offre 3) — acceptée
        DB::table('postulations')->insert([
            'offre_id' => 3,
            'etu_id'   => 3,
            'state'    => 2,
            'motiv'    => 'La cybersécurité est ma spécialité depuis 2 ans. J\'ai participé à plusieurs CTF et réalisé des audits de sécurité en formation. Intégrer Airbus serait un honneur et une chance d\'évoluer dans un secteur critique.',
            'path'     => '',
        ]);

        // Léa Martin (etu 3) → IA/ML chez Safran (offre 9) — en attente
        DB::table('postulations')->insert([
            'offre_id' => 9,
            'etu_id'   => 3,
            'state'    => 1,
            'motiv'    => 'L\'intelligence artificielle appliquée à l\'industrie m\'a toujours fascinée. Ayant suivi un cours de machine learning et travaillé avec TensorFlow, je me sens prête à contribuer à vos projets R&D.',
            'path'     => '',
        ]);

        // Thomas Dubois (etu 4) → Dev Web Full Stack chez Total (offre 1) — en attente
        DB::table('postulations')->insert([
            'offre_id' => 1,
            'etu_id'   => 4,
            'state'    => 1,
            'motiv'    => 'Je souhaite développer mes compétences full-stack dans un environnement professionnel stimulant. Mes projets en Laravel et JavaScript me permettront de contribuer rapidement à vos équipes.',
            'path'     => '',
        ]);

        // Thomas Dubois (etu 4) → DevOps/Cloud chez Capgemini (offre 7) — confirmée
        DB::table('postulations')->insert([
            'offre_id' => 7,
            'etu_id'   => 4,
            'state'    => 3,
            'motiv'    => 'Passionné par le DevOps et l\'automatisation, j\'ai déjà mis en place des pipelines CI/CD avec GitLab et utilisé Docker dans plusieurs projets. Ce stage chez Capgemini correspond exactement à mes objectifs professionnels.',
            'path'     => '',
        ]);

        // Camille Lefèvre (etu 5) → Backend Java chez BNP (offre 8) — acceptée
        DB::table('postulations')->insert([
            'offre_id' => 8,
            'etu_id'   => 5,
            'state'    => 2,
            'motiv'    => 'Désireuse d\'acquérir une expérience dans le secteur bancaire, je maîtrise Java Spring Boot et l\'architecture microservices. La rigueur exigée dans ce domaine correspond à ma façon de travailler.',
            'path'     => '',
        ]);

        // Camille Lefèvre (etu 5) → Mobile chez Total (offre 4) — en attente
        DB::table('postulations')->insert([
            'offre_id' => 4,
            'etu_id'   => 5,
            'state'    => 1,
            'motiv'    => 'Le développement mobile me passionne depuis ma découverte de Flutter. J\'ai réalisé une application complète en Dart pour mon projet de fin d\'année et souhaite poursuivre dans cette direction.',
            'path'     => '',
        ]);

        // --- Comptes de test (entreprise@example.com = testEnt, offre 5) ---

        // Test Etu (etu 1) → testOffreTele (offre 5, testEnt) — en attente
        DB::table('postulations')->insert([
            'offre_id' => 5,
            'etu_id'   => 1,
            'state'    => 1,
            'motiv'    => 'Je suis très motivé par cette offre de stage et souhaite mettre en pratique mes compétences acquises en cours.',
            'path'     => '',
        ]);

        // Jean Dupont (etu 2) → testOffreTele (offre 5, testEnt) — acceptée
        DB::table('postulations')->insert([
            'offre_id' => 5,
            'etu_id'   => 2,
            'state'    => 2,
            'motiv'    => 'Cette offre correspond parfaitement à mon profil et aux compétences que j\'ai développées tout au long de ma formation.',
            'path'     => '',
        ]);

        // Léa Martin (etu 3) → testOffreTele (offre 5, testEnt) — confirmée
        DB::table('postulations')->insert([
            'offre_id' => 5,
            'etu_id'   => 3,
            'state'    => 3,
            'motiv'    => 'Je suis enthousiaste à l\'idée de rejoindre votre équipe. Mes expériences passées me permettront de contribuer efficacement dès le premier jour.',
            'path'     => '',
        ]);

        // Test Etu (etu 1) → testOffrePasTele (offre 6, testEnt2) — en attente
        DB::table('postulations')->insert([
            'offre_id' => 6,
            'etu_id'   => 1,
            'state'    => 1,
            'motiv'    => 'Votre offre de stage m\'intéresse beaucoup. Je souhaite apporter ma contribution et développer mes compétences dans ce domaine.',
            'path'     => '',
        ]);
    }
}
