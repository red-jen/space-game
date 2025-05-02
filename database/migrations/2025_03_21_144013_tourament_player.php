<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
     
    public function up(): void
    {
        Schema::create('tournament_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['registered', 'confirmed', 'cancelled'])
                  ->default('registered');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
            
            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['tournament_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_player');
    }
};
