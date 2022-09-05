<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeGeneralPhysicalExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_general_physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_treat_id')->unsigned()->nullable();
            $table->foreign('employee_treat_id')->references('id')
            ->on('employee_treatments')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('awareness',50)->nullable();
            $table->string('distress_sign',50)->nullable();
            $table->string('anxiety_sign',50)->nullable();
            $table->string('sign_of_pain',50)->nullable();
            $table->string('voice',50)->nullable();
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
        Schema::dropIfExists('employee_general_physical_examinations');
    }
}
