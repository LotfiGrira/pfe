<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('regles', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('heir_type'); // exemple: 'fils'
            $table->text('condition');   // exemple: "présence d’un fils"
            $table->enum('effet', ['exclure', 'réduire']);
            $table->string('cible');     // exemple: 'frère'
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('regles');
    }
};
