<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('miraths', function (Blueprint $table) {
            $table->id();
            $table->string('warith'); // Nom de l’héritier (Ex: ALJAD, ALAB, AZAWJ)
            $table->text('sharh'); // Explication du calcul
            $table->integer('bast'); // Numérateur de la fraction
            $table->integer('maqam'); // Dénominateur de la fraction
            $table->boolean('ta3seeb')->default(false); // S'il hérite par Ta3seeb (oui/non)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('miraths');
    }
};
