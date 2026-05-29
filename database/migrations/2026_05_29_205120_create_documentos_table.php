<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semestre_id')->constrained('semestres')->cascadeOnDelete();
            $table->foreignId('carpeta_id')->constrained('carpetas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('archivo');
            $table->string('extension', 20);
            $table->unsignedBigInteger('tamano');
            $table->timestamp('fecha_subida');
            $table->timestamps();

            $table->index(['nombre', 'extension']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
