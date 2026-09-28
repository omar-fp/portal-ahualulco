<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 8)->unique();
            $table->foreignId('tipo_reporte_id')
                ->constrained('tipo_reportes')
                ->restrictOnDelete();
            $table->string('nombre_ciudadano', 100);
            $table->string('calle', 120);
            $table->foreignId('colonia_id')->constrained('colonias');
            $table->text('descripcion');
            $table->string('estado', 20)->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
