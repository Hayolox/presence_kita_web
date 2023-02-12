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
        Schema::create('lecturer_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('lecturer_nip');
            $table->foreign('lecturer_nip')->references('nip')->on('lecturers');
            $table->string('subject_course_code');
            $table->foreign('subject_course_code')->references('course_code')->on('subjects');
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
        Schema::dropIfExists('lecturer_subjects');
    }
};
