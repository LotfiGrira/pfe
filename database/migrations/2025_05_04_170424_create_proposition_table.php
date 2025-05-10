<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('proposition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('heir_id')->constrained('heirs')->onDelete('cascade');
            $table->text('description');
            $table->string('fraction');
            $table->boolean('est_valide')->default(true);
            $table->text('raison_invalide')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('proposition');
    }
};
