<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeHospitalizationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_hospitalization_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_health_id')->unsigned()->nullable();
            $table->foreign('employee_health_id')->references('id')
            ->on('employee_current_health_histories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('hospital_name',50)->nullable();
            $table->date('date_treated')->nullable();
            $table->string('diagnosis',50)->nullable();
            $table->string('other_diagnosis',50)->nullable();
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
        Schema::dropIfExists('employee_hospitalization_histories');
    }
}
