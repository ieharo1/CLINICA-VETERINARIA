<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cirugias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nombre');
            $table->dateTime('fecha_cirugia');
            $table->text('descripcion')->nullable();
            $table->text('preoperatorio')->nullable();
            $table->text('postoperatorio')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['programada', 'en_progreso', 'completada', 'cancelada'])->default('programada');
            $table->decimal('costo', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cirugias');
    }
};
