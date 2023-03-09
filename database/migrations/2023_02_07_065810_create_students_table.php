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
        Schema::create('students', function (Blueprint $table) {
            $table->string("nsn", 50)->primary();
            $table->string("name", 100);
            $table->integer("generation");
            $table->string('password');
            $table->unsignedBigInteger('major_id');
            $table->foreign('major_id')->references('id')->on('majors');
            $table->string('android_id')->nullable();
            $table->string('roles')->default('mahasiswa');
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
        Schema::dropIfExists('students');
    }
};
