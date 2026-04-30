<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('commentaire__stages');
        Schema::dropIfExists('commentaires');
        Schema::dropIfExists('stages');
    }

    public function down(): void
    {
        // Ces tables n'étaient pas utilisées en production, pas de rollback
    }
};
