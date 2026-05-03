<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostulationCommentairesTableSeeder extends Seeder
{
    public function run(): void
    {
        // user_id entreprises : Thales=3, Dassault=4, Orange=5, Airbus=6,
        //                       Capgemini=7, BNP=8, SocGen=9, Safran=10, Ubisoft=11, Criteo=12
        // user_id étudiants   : Antoine=13, Léa=14, Thomas=15, Camille=16,
        //                       Hugo=17, Emma=18, Maxime=19, Chloé=20, Nicolas=21, Inès=22

        // Postulation 1 : Antoine (user=13) / Orange (user=5) — Full Stack — state=3
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1, 'user_id' => 13,
            'body'       => 'Bonjour, je viens de recevoir la confirmation de mon stage, merci beaucoup ! Pourriez-vous me préciser les horaires habituels et si je dois apporter mon propre matériel le premier jour ?',
            'created_at' => now()->subDays(8), 'updated_at' => now()->subDays(8),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1, 'user_id' => 5,
            'body'       => 'Bonjour Antoine, bienvenue dans l\'équipe ! Les horaires sont de 9h à 17h30, du lundi au vendredi. Un poste de travail équipé vous sera attribué dès votre arrivée. Présentez-vous à l\'accueil du 78 rue Olivier de Serres le lundi 2 juin à 9h00, un badge vous y sera remis.',
            'created_at' => now()->subDays(7), 'updated_at' => now()->subDays(7),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1, 'user_id' => 13,
            'body'       => 'Parfait, merci pour ces informations ! Je serai là le 2 juin à 9h pétantes. J\'ai hâte de découvrir votre équipe et de contribuer au projet.',
            'created_at' => now()->subDays(6), 'updated_at' => now()->subDays(6),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1, 'user_id' => 5,
            'body'       => 'Super ! D\'ici là n\'hésitez pas si vous avez des questions. Votre tuteur, Romain Leroy, vous contactera la semaine avant le démarrage pour un point de pré-intégration.',
            'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5),
        ]);

        // Postulation 7 : Camille (user=16) / Capgemini (user=7) — Java — state=3
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 7, 'user_id' => 16,
            'body'       => 'Bonjour, je suis ravie d\'avoir été retenue ! Auriez-vous des recommandations pour me préparer avant le début du stage ? Y a-t-il des outils ou frameworks spécifiques que vous utilisez sur ce projet ?',
            'created_at' => now()->subDays(10), 'updated_at' => now()->subDays(10),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 7, 'user_id' => 7,
            'body'       => 'Bonjour Camille, félicitations ! Nous travaillons avec Spring Boot 3, JUnit 5 et une architecture microservices déployée sur AWS ECS. Si vous n\'avez pas encore touché à Spring Boot 3, je vous recommande de parcourir la documentation officielle. Une journée d\'onboarding technique est prévue dès votre arrivée.',
            'created_at' => now()->subDays(9), 'updated_at' => now()->subDays(9),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 7, 'user_id' => 16,
            'body'       => 'Merci beaucoup ! J\'ai déjà commencé à revoir Spring Boot 3 et les patterns de microservices. J\'ai aussi regardé la documentation AWS ECS, c\'est très différent de ce qu\'on fait en cours mais très intéressant. À très bientôt !',
            'created_at' => now()->subDays(8), 'updated_at' => now()->subDays(8),
        ]);

        // Postulation 11 : Emma (user=18) / Société Générale (user=9) — IA — state=3
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 11, 'user_id' => 18,
            'body'       => 'Bonjour, je suis très heureuse de rejoindre votre équipe ! Pourriez-vous me préciser sur quel type de données je serai amenée à travailler et si TensorFlow est le framework principal utilisé ?',
            'created_at' => now()->subDays(12), 'updated_at' => now()->subDays(12),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 11, 'user_id' => 9,
            'body'       => 'Bonjour Emma, bienvenue ! Vous travaillerez sur des flux de transactions anonymisés. Nous utilisons principalement PyTorch pour les modèles de détection d\'anomalies, TensorFlow étant en cours de migration. L\'environnement de dev est sous Python 3.11 avec MLflow pour le tracking des expériences. On se retrouve le 9 juin !',
            'created_at' => now()->subDays(11), 'updated_at' => now()->subDays(11),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 11, 'user_id' => 18,
            'body'       => 'Merci pour ces précisions ! Je vais prendre le temps de me familiariser avec PyTorch et MLflow d\'ici là. Est-ce que vous avez des ressources internes ou des notebooks de démarrage que vous pouvez partager ?',
            'created_at' => now()->subDays(10), 'updated_at' => now()->subDays(10),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 11, 'user_id' => 9,
            'body'       => 'Bien sûr, votre tutrice vous partagera un dépôt GitLab interne avec des exemples dès le premier jour. En attendant, la documentation officielle de MLflow et les tutoriels PyTorch sur pytorch.org sont une excellente base.',
            'created_at' => now()->subDays(9), 'updated_at' => now()->subDays(9),
        ]);

        // Postulation 19 : Inès (user=22) / Criteo (user=12) — ML — state=3
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 19, 'user_id' => 22,
            'body'       => 'Bonjour, je suis très enthousiaste à l\'idée de travailler chez Criteo ! J\'aurais une question : les modèles sur lesquels je vais travailler sont-ils surtout des modèles de ranking ou aussi du collaborative filtering ?',
            'created_at' => now()->subDays(6), 'updated_at' => now()->subDays(6),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 19, 'user_id' => 12,
            'body'       => 'Bonjour Inès, bonne question ! Vous interviendrez principalement sur des modèles de learning-to-rank (LTR) avec LightGBM, mais vous aurez aussi un aperçu de notre approche hybride qui intègre du collaborative filtering pour le cold start. On a hâte de vous accueillir !',
            'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 19, 'user_id' => 22,
            'body'       => 'Super, c\'est exactement ce sur quoi j\'ai travaillé lors de mes projets académiques ! Je vais relire la littérature sur LTR avant d\'arriver. Merci pour ces précisions, à très bientôt.',
            'created_at' => now()->subDays(4), 'updated_at' => now()->subDays(4),
        ]);
    }
}
