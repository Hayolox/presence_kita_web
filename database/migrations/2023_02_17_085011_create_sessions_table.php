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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('QrCode', 20);
            $table->string("title", 100);
            $table->time('start');
            $table->time('finish');
            $table->date('date');
            $table->string('lecturer_nip');
            $table->foreign('lecturer_nip')->references('nip')->on('lecturers');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->string('subject_course_code');
            $table->foreign('subject_course_code')->references('course_code')->on('subjects')->onDelete('cascade');
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
        Schema::dropIfExists('sessions');
    }
};
