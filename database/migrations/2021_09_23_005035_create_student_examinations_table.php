<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_examinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_mcu_id')->unsigned()->nullable();
            $table->foreign('student_mcu_id')->references('id')
            ->on('student_mcus')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('weight',5)->nullable();
            $table->string('height',5)->nullable();
            $table->string('bmi_calculation_results',50)->nullable();
            $table->string('bmi_diagnosis',15)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('age',10)->nullable();
            $table->string('lk',5)->nullable();
            $table->string('lila',5)->nullable();
            $table->string('conclusion_lk',50)->nullable();
            $table->string('conclusion_lila',50)->nullable();
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
        Schema::dropIfExists('student_examinations');
    }
}
