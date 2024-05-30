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
        Schema::create('schedule', function (Blueprint $table) {
            $table->id("scheduleid");
            $table->unsignedBigInteger('docid');
            $table->string('title');
            $table->date('scheduledate');
            $table->time("scheduletime");
            $table->integer('nop');
            $table->foreign('docid')->references("docid")->on('doctor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
};
