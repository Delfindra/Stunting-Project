<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_gizi', function (Blueprint $table) {
            $table->unsignedBigInteger('anak_id');
            $table->string('TB/U');
            $table->string('BB/U');
            $table->string('BB/PB');
            $table->string('tindakan');
            $table->decimal('berat_badan');
            $table->decimal('tinggi_badan');
            $table->timestamp('tanggal_periksa')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->foreign('anak_id')->references('id')->on('anak')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_gizi');
    }
};
