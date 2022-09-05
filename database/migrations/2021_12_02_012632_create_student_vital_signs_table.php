<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVitalSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_vital_signs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_treat_id')->unsigned()->nullable();
            $table->foreign('student_treat_id')->references('id')
            ->on('student_treatments')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('blood_pressure',10)->nullable();
            $table->string('heart_rate',10)->nullable();
            $table->string('breathing_ratio',10)->nullable();
            $table->string('body_temperature',10)->nullable();
            $table->string('sp02',10)->nullable();
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
        Schema::dropIfExists('student_vital_signs');
    }
}
