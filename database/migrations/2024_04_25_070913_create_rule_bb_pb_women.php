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
        Schema::create('rule_bb_pb_women', function (Blueprint $table) {
            $table->float('length_cm'); // Panjang badan dalam cm
            $table->float('minus_three_sd'); // -3 SD
            $table->float('minus_two_sd'); // -2 SD
            $table->float('minus_one_sd'); // -1 SD
            $table->float('median'); // Median
            $table->float('plus_one_sd'); // +1 SD
            $table->float('plus_two_sd'); // +2 SD
            $table->float('plus_three_sd'); // +3 SD
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_bb_pb_women');
    }
};
