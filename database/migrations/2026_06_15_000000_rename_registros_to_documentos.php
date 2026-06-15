<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('registros') && !Schema::hasTable('documentos')) {
            Schema::rename('registros', 'documentos');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('documentos') && !Schema::hasTable('registros')) {
            Schema::rename('documentos', 'registros');
        }
    }
};
