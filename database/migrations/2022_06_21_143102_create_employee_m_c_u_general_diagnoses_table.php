<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMCUGeneralDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_m_c_u_general_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_mcu_id')->unsigned()->nullable();
            $table->foreign('employee_mcu_id')->references('id')
            ->on('employee_mcus')
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
        Schema::dropIfExists('employee_m_c_u_general_diagnoses');
    }
}
