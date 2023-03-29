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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('balita_id');
            $table->string('berat', 5);
            $table->string('tinggi', 5);
            $table->string('usia');
            $table->string('bb/u');
            $table->string('tb/u');
            $table->string('bb/tb');
            $table->string('zs_bb/u', 5);
            $table->string('zs_tb/u', 5);
            $table->string('zs_bb/tb', 5);
            $table->timestamps();
            $table->foreign('balita_id')->references('id')->on('balita')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
