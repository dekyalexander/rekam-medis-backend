<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAnamnesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_anamnesis', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_mcu_id');
            $table->string('onset',30)->nullable();
            $table->string('frequency',30)->nullable();
            $table->string('complaint_development',30)->nullable();
            $table->string('things_that_trigger_complaints',30)->nullable();
            $table->string('things_to_reduce_complaints',30)->nullable();
            $table->string('another_complaint',30)->nullable();
            $table->string('common_symptoms',30)->nullable();
            $table->string('skin_symptoms',30)->nullable();
            $table->string('sensory_symptoms',30)->nullable();
            $table->string('respiratory_symptoms',30)->nullable();
            $table->string('cardiovascular_symptoms',30)->nullable();
            $table->string('digestive_symptoms',30)->nullable();
            $table->string('nervous_symptoms',30)->nullable();
            $table->string('psychological_symptoms',30)->nullable();
            $table->string('endocrine_symptoms',30)->nullable();
            $table->string('musculoskeletal_symptoms',30)->nullable();
            $table->string('past_medical_history',30)->nullable();
            $table->string('when_diagnosed',30)->nullable();
            $table->string('where_was_diagnosed',30)->nullable();
            $table->string('by_whom_was_diagnosed',30)->nullable();
            $table->string('how_is_the_treatment',30)->nullable();
            $table->string('allergy_history',30)->nullable();
            $table->string('drugs_that_have_been_taken',30)->nullable();
            $table->string('type_of_medicine_and_for_how_long',30)->nullable();
            $table->string('habit_history',30)->nullable();
            $table->string('family_history',30)->nullable();
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
        Schema::dropIfExists('employee_anamnesis');
    }
}
