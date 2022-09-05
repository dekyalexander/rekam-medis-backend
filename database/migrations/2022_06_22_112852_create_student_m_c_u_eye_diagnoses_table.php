<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMCUEyeDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_m_c_u_eye_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_mcu_id')->unsigned()->nullable();
            $table->foreign('student_mcu_id')->references('id')
            ->on('student_mcus')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('diagnosis_eye_id',50)->nullable();
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
        Schema::dropIfExists('student_m_c_u_eye_diagnoses');
    }
}
