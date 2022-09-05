<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMedicalPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_medical_prescriptions', function (Blueprint $table) {
            $table->id();
             $table->bigInteger('student_treat_id')->unsigned()->nullable();
            $table->foreign('student_treat_id')->references('id')
            ->on('student_treatments')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('location_id',30)->nullable();
            $table->string('drug_id',30)->nullable();
            $table->integer('amount_medicine')->nullable();
            $table->string('unit',20)->nullable();
            $table->string('how_to_use_medicine',50)->nullable();
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
        Schema::dropIfExists('student_medical_prescriptions');
    }
}
