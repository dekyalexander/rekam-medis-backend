<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentGeneralPhysicalExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_general_physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_treat_id')->unsigned()->nullable();
            $table->foreign('student_treat_id')->references('id')
            ->on('student_treatments')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('awareness',30)->nullable();
            $table->string('distress_sign',30)->nullable();
            $table->string('anxiety_sign',30)->nullable();
            $table->string('sign_of_pain',30)->nullable();
            $table->string('voice',30)->nullable();
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
        Schema::dropIfExists('student_general_physical_examinations');
    }
}
