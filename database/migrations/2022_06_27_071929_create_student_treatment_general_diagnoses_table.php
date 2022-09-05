<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTreatmentGeneralDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_treatment_general_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_treat_id')->unsigned()->nullable();
            $table->foreign('student_treat_id')->references('id')
            ->on('student_treatments')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('diagnosis_id',50)->nullable();
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
        Schema::dropIfExists('student_treatment_general_diagnoses');
    }
}
