<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMedicalPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_medical_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_treat_id')->unsigned()->nullable();
            $table->foreign('employee_treat_id')->references('id')
            ->on('employee_treatments')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('location_id',30)->nullable();
            $table->string('drug_id',30)->nullable();
            $table->integer('amount_medicine')->nullable();
            $table->string('unit_drug',20)->nullable();
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
        Schema::dropIfExists('employee_medical_prescriptions');
    }
}
