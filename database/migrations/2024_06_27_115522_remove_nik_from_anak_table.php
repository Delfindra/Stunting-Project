<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDuplicateNikFromAnakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anak', function (Blueprint $table) {
            // Hapus kolom NIK jika ada duplikat
            $table->dropColumn('nik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anak', function (Blueprint $table) {
            // Tambahkan kolom NIK kembali jika diperlukan
            $table->char('nik', 16)->unique()->notNullable()->after('id');
        });
    }
}

