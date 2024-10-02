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
            $table->decimal('z_score_bbu');
            $table->decimal('z_score_tbu');
            $table->decimal('z_score_bbpb');
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
            //
        });
    }
};
