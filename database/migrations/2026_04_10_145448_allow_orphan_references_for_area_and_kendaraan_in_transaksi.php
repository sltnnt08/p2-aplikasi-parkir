<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $databaseDriver = Schema::getConnection()->getDriverName();

        if ($databaseDriver === 'sqlite') {
            $this->recreateTransaksiTableWithoutAreaAndKendaraanForeignKeys();

            return;
        }

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->dropForeign(['id_kendaraan']);
            $table->dropForeign(['id_area']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $databaseDriver = Schema::getConnection()->getDriverName();

        if ($databaseDriver === 'sqlite') {
            $this->recreateTransaksiTableWithAreaAndKendaraanForeignKeys();

            return;
        }

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->foreign('id_kendaraan')
                ->references('id_kendaraan')
                ->on('tb_kendaraan')
                ->restrictOnDelete();

            $table->foreign('id_area')
                ->references('id_area')
                ->on('tb_area_parkir')
                ->restrictOnDelete();
        });
    }

    private function recreateTransaksiTableWithoutAreaAndKendaraanForeignKeys(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');

        Schema::rename('tb_transaksi', 'tb_transaksi_old');

        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_parkir');
            $table->foreignId('id_kendaraan');
            $table->datetime('waktu_masuk');
            $table->datetime('waktu_keluar')->nullable();
            $table->foreignId('id_tarif')
                ->constrained('tb_tarif', 'id_tarif')
                ->restrictOnDelete();
            $table->integer('durasi_jam')->nullable();
            $table->decimal('biaya_total', 10, 0)->nullable();
            $table->enum('status', ['masuk', 'keluar']);
            $table->foreignId('id_user')
                ->constrained('tb_user', 'id_user')
                ->restrictOnDelete();
            $table->foreignId('id_area');
        });

        DB::statement('
            INSERT INTO tb_transaksi (
                id_parkir, id_kendaraan, waktu_masuk, waktu_keluar, id_tarif,
                durasi_jam, biaya_total, status, id_user, id_area
            )
            SELECT
                id_parkir, id_kendaraan, waktu_masuk, waktu_keluar, id_tarif,
                durasi_jam, biaya_total, status, id_user, id_area
            FROM tb_transaksi_old
        ');

        Schema::drop('tb_transaksi_old');

        DB::statement('PRAGMA foreign_keys = ON');
    }

    private function recreateTransaksiTableWithAreaAndKendaraanForeignKeys(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');

        Schema::rename('tb_transaksi', 'tb_transaksi_old');

        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_parkir');
            $table->foreignId('id_kendaraan')
                ->constrained('tb_kendaraan', 'id_kendaraan')
                ->restrictOnDelete();
            $table->datetime('waktu_masuk');
            $table->datetime('waktu_keluar')->nullable();
            $table->foreignId('id_tarif')
                ->constrained('tb_tarif', 'id_tarif')
                ->restrictOnDelete();
            $table->integer('durasi_jam')->nullable();
            $table->decimal('biaya_total', 10, 0)->nullable();
            $table->enum('status', ['masuk', 'keluar']);
            $table->foreignId('id_user')
                ->constrained('tb_user', 'id_user')
                ->restrictOnDelete();
            $table->foreignId('id_area')
                ->constrained('tb_area_parkir', 'id_area')
                ->restrictOnDelete();
        });

        DB::statement('
            INSERT INTO tb_transaksi (
                id_parkir, id_kendaraan, waktu_masuk, waktu_keluar, id_tarif,
                durasi_jam, biaya_total, status, id_user, id_area
            )
            SELECT
                id_parkir, id_kendaraan, waktu_masuk, waktu_keluar, id_tarif,
                durasi_jam, biaya_total, status, id_user, id_area
            FROM tb_transaksi_old
        ');

        Schema::drop('tb_transaksi_old');

        DB::statement('PRAGMA foreign_keys = ON');
    }
};
