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
        Schema::create('tbu_laki', function (Blueprint $table) {
            $table->id();
            $table->double('usia', 5);
            $table->double('min3sd', 5);
            $table->double('min2sd', 5);
            $table->double('min1sd', 5);
            $table->double('median', 5);
            $table->double('plus1sd', 5);
            $table->double('plus2sd', 5);
            $table->double('plus3sd', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_per_usia_laki');
    }
};
