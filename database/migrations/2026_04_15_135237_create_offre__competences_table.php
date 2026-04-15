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
        Schema::create('offre__competences', function (Blueprint $table) {
            $table->unsignedBigInteger('offre_id');
            $table->unsignedBigInteger('skill_id');
            $table->foreign('offre_id')->references('id')->on('offres');
            $table->foreign('skill_id')->references('id')->on('competences');
            $table->primary(['offre_id', 'skill_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre__competences');
    }
};
