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
        Schema::create('rule_tb_u_women', function (Blueprint $table) {
            $table->integer('age_months'); 
            $table->float('minus_three_sd');
            $table->float('minus_two_sd');
            $table->float('minus_one_sd');
            $table->float('median');
            $table->float('plus_one_sd');
            $table->float('plus_two_sd');
            $table->float('plus_three_sd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_tb_u_women');
    }
};
