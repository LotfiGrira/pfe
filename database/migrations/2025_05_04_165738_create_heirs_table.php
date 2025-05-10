<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('heirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('heritage_id')->constrained('heritages')->onDelete('cascade');
            $table->string('nom');
            $table->enum('lien', ['fils', 'fille', 'époux', 'épouse', 'mère', 'père', 'frère', 'sœur']);
            $table->enum('sexe', ['H', 'F']);
            $table->boolean('is_alive')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('heirs');
    }
};
