<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('raza_id')->nullable()->constrained('razas')->onDelete('set null');
            $table->string('nombre');
            $table->string('especie');
            $table->string('genero');
            $table->date('fecha_nacimiento');
            $table->string('color')->nullable();
            $table->string('peso')->nullable();
            $table->string('foto')->nullable();
            $table->text('notas')->nullable();
            $table->boolean('esterilizado')->default(false);
            $table->date('fecha_esterilizacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
