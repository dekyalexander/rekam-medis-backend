<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMcusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_mcus', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('nik',10)->nullable();
            $table->string('unit',20)->nullable();
            $table->date('inspection_date');
            $table->string('blood_pressure',30)->nullable();
            $table->string('heart_rate',30)->nullable();
            $table->string('breathing_ratio',30)->nullable();
            $table->string('body_temperature',30)->nullable();
            $table->string('sp02',30)->nullable();
            $table->string('weight',30)->nullable();
            $table->string('height',30)->nullable();
            $table->string('bmi_calculation_results',30)->nullable();
            $table->string('bmi_diagnosis',30)->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('employee_mcus');
    }
}
