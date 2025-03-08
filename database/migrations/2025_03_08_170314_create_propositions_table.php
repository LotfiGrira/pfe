<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercice_id')->constrained()->onDelete('cascade'); // Lien avec exercices
            $table->text('propos'); // Texte de la proposition
            $table->boolean('is_true')->default(false); // Indique si la proposition est vraie
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propositions');
    }
};
