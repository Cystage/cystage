<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offre__domaines', function (Blueprint $table) {
            $table->unsignedBigInteger('offre_id');
            $table->unsignedBigInteger('dom_id');
            $table->foreign('offre_id')->references('id')->on('offres');
            $table->foreign('dom_id')->references('id')->on('domaines');
            $table->primary(['offre_id', 'dom_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre__domaines');
    }
};
