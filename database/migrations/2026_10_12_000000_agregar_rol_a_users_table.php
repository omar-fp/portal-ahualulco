<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol', 20)->default('area')->after('password');
            $table->foreignId('tipo_reporte_id')
                ->nullable()
                ->after('rol')
                ->constrained('tipo_reportes')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tipo_reporte_id']);
            $table->dropColumn(['tipo_reporte_id', 'rol']);
        });
    }
};
