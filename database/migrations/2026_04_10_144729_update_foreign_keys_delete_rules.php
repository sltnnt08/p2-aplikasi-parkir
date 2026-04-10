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
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->dropForeign(['id_kendaraan']);
            $table->dropForeign(['id_tarif']);
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_area']);

            $table->foreign('id_kendaraan')
                ->references('id_kendaraan')
                ->on('tb_kendaraan')
                ->restrictOnDelete();

            $table->foreign('id_tarif')
                ->references('id_tarif')
                ->on('tb_tarif')
                ->restrictOnDelete();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('tb_user')
                ->restrictOnDelete();

            $table->foreign('id_area')
                ->references('id_area')
                ->on('tb_area_parkir')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->dropForeign(['id_kendaraan']);
            $table->dropForeign(['id_tarif']);
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_area']);

            $table->foreign('id_kendaraan')
                ->references('id_kendaraan')
                ->on('tb_kendaraan');

            $table->foreign('id_tarif')
                ->references('id_tarif')
                ->on('tb_tarif');

            $table->foreign('id_user')
                ->references('id_user')
                ->on('tb_user');

            $table->foreign('id_area')
                ->references('id_area')
                ->on('tb_area_parkir');
        });
    }
};
