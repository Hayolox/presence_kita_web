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
        Schema::create('presence_pratikums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_pratikum_id');
            $table->foreign('session_pratikum_id')->references('id')->on('sessionpratikums');
            $table->unsignedBigInteger('classroomspratikum_id');
            $table->foreign('classroomspratikum_id')->references('id')->on('classroomspratikums');
            $table->string('student_nsn');
            $table->foreign('student_nsn')->references('nsn')->on('students');
            $table->string("status")->nullable();
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
        Schema::dropIfExists('presence_pratikums');
    }
};
