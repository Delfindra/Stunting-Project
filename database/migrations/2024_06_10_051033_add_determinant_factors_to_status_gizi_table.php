<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_gizi', function (Blueprint $table) {
            $table->string('airBersih')->default('Belum ada data');
            $table->string('jambanSehat')->default('Belum ada data');
            $table->string('imunisasi')->default('Belum ada data');
            $table->string('kecacingan')->default('Belum ada data');
            $table->string('merokok')->default('Belum ada data');
            $table->string('riwayatKehamilan')->default('Belum ada data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_gizi', function (Blueprint $table) {
            $table->dropColumn('airBersih');
            $table->dropColumn('jambanSehat');
            $table->dropColumn('imunisasi');
            $table->dropColumn('kecacingan');
            $table->dropColumn('merokok');
            $table->dropColumn('riwayatKehamilan');
        });
    }
};
