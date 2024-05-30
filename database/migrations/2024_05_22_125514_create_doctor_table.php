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
        Schema::create('doctor', function (Blueprint $table) {
            $table->id("docid");
            $table->string("docemail")->unique();
            $table->string("docname");
            $table->string("docpassword");
            $table->string("docnic");
            $table->string("doctel");
            $table->unsignedBigInteger("docspecialitie");
            $table->foreign('docspecialitie')->references('sid')->on("specialities");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor');
    }
};
