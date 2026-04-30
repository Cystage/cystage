<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostulationCommentairesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Postulation 1 : Jean Dupont (user 6) / Total (user 5) — Dev Web — state=3
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1,
            'user_id'        => 6,
            'body'           => 'Bonjour, j\'ai bien reçu la confirmation de mon stage. Pourriez-vous m\'indiquer les horaires de travail ainsi que l\'adresse exacte du lieu d\'accueil ?',
            'created_at'     => now()->subDays(5),
            'updated_at'     => now()->subDays(5),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1,
            'user_id'        => 5,
            'body'           => 'Bonjour Jean, vous travaillerez de 9h à 17h30 du lundi au vendredi. L\'accueil est prévu le lundi 2 juin à 8h45 au 12 rue de la Paix, Paris 1er. Un badge vous sera remis à l\'entrée.',
            'created_at'     => now()->subDays(4),
            'updated_at'     => now()->subDays(4),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 1,
            'user_id'        => 6,
            'body'           => 'Merci beaucoup pour ces précisions ! Je serai présent le 2 juin sans faute. J\'ai hâte de commencer et de rejoindre votre équipe.',
            'created_at'     => now()->subDays(3),
            'updated_at'     => now()->subDays(3),
        ]);

        // Postulation 6 : Thomas Dubois (user 10) / Capgemini (user 12) — DevOps — state=3
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 6,
            'user_id'        => 10,
            'body'           => 'Bonjour, je suis très enthousiaste à l\'idée de rejoindre votre équipe. Pourriez-vous me préciser quels outils DevOps sont principalement utilisés pour que je puisse me préparer avant mon arrivée ?',
            'created_at'     => now()->subDays(7),
            'updated_at'     => now()->subDays(7),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 6,
            'user_id'        => 12,
            'body'           => 'Bonjour Thomas, nous travaillons principalement avec Kubernetes, Terraform et GitLab CI/CD sur infrastructure AWS. Une semaine de formation interne est prévue dès votre arrivée, donc pas de panique ! À très bientôt.',
            'created_at'     => now()->subDays(6),
            'updated_at'     => now()->subDays(6),
        ]);
        DB::table('postulation_commentaires')->insert([
            'postulation_id' => 6,
            'user_id'        => 10,
            'body'           => 'Super, merci pour ces informations ! Je vais profiter de ces quelques semaines pour avancer sur Terraform et Kubernetes. À très bientôt !',
            'created_at'     => now()->subDays(5),
            'updated_at'     => now()->subDays(5),
        ]);
    }
}
