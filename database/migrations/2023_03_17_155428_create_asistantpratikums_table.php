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
        Schema::create('asistantpratikums', function (Blueprint $table) {
            $table->id();
            $table->string('student_nsn');
            $table->foreign('student_nsn')->references('nsn')->on('students');
            $table->unsignedBigInteger('classroomspratikum_id');
            $table->foreign('classroomspratikum_id')->references('id')->on('classroomspratikums');
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
        Schema::dropIfExists('asistantpratikums');
    }
};
