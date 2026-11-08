<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            // Día en que el reporte se marcó como Atendido
            $table->date('atendido_en')->nullable()->after('estado');
            $table->text('causa')->nullable()->after('atendido_en');
        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropColumn(['atendido_en', 'causa']);
        });
    }
};
