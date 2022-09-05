<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFamilyHistoryOfIllnessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_family_history_of_illnesses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_health_id')->unsigned()->nullable();
            $table->foreign('student_health_id')->references('id')
            ->on('student_current_health_histories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('family_history_of_illness',50)->nullable();
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
        Schema::dropIfExists('student_family_history_of_illnesses');
    }
}
