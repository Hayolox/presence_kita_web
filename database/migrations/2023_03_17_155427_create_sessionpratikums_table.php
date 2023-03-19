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
        Schema::create('sessionpratikums', function (Blueprint $table) {
            $table->id();
            $table->string('QrCode', 20);
            $table->string("title", 100);
            $table->time('start');
            $table->time('finish');
            $table->date('date');
            $table->string('student_nsn');
            $table->foreign('student_nsn')->references('nsn')->on('students');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->unsignedBigInteger('classroomspratikum_id');
            $table->foreign('classroomspratikum_id')->references('id')->on('classroomspratikums');
            $table->integer("year");
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->boolean('geolocation');
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
        Schema::dropIfExists('sessionpratikums');
    }
};
