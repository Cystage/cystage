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
        Schema::create('commentaire__stages', function (Blueprint $table) {
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('comm_id');
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->foreign('comm_id')->references('id')->on('commentaires');
            $table->primary(['stage_id', 'comm_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaire__stages');
    }
};
