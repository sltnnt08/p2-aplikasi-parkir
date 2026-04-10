<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_tarif', function (Blueprint $table) {
            $table->foreignId('id_area')
                ->nullable()
                ->after('id_tarif')
                ->constrained('tb_area_parkir', 'id_area')
                ->nullOnDelete();

            $table->unique(['id_area', 'jenis_kendaraan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_tarif', function (Blueprint $table) {
            $table->dropUnique('tb_tarif_id_area_jenis_kendaraan_unique');
            $table->dropConstrainedForeignId('id_area');
        });
    }
};
