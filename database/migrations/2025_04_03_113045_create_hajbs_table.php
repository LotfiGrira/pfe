<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hajbs', function (Blueprint $table) {
            $table->id();
            $table->string('warith'); // Héritier bloqué
            $table->integer('count')->nullable(); // Nombre d'héritiers bloqués (ex: nombre de frères)
            $table->string('blocker'); // Héritier qui bloque
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hajbs');
    }
};
