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
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('ent_id');
            $table->foreign('ent_id')->references('id')->on('entreprises');
            $table->integer('nb_week');
            $table->integer('week_hour');
            $table->float('paye_hour');
            $table->boolean('teletrav');
            $table->text('poste_desc');
            $table->text('profil_desc');
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
