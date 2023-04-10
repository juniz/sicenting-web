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
        Schema::create('polri', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->index()->nullable();
            $table->string('nrp', 20);
            $table->bigInteger('pangkat')->unsigned()->index()->nullable();
            $table->bigInteger('kesatuan')->unsigned()->index()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pangkat')->references('id')->on('pangkat');
            $table->foreign('kesatuan')->references('id')->on('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polri');
    }
};
