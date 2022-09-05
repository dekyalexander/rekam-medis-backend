<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTreatmentGeneralDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_treatment_general_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_treat_id')->unsigned()->nullable();
            $table->foreign('employee_treat_id')->references('id')
            ->on('employee_treatments')
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
        Schema::dropIfExists('employee_treatment_general_diagnoses');
    }
}
