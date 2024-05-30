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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id("appid");
            $table->unsignedBigInteger("pid");
            $table->foreign("pid")->references("pid")->on("patient");
            $table->integer('appnum');
            $table->unsignedBigInteger('scheduleid');
            $table->foreign('scheduleid')->references('scheduleid')->on('schedule');
            $table->date('appdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment');
    }
};
