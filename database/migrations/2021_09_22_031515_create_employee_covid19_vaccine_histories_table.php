<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCovid19VaccineHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_covid19_vaccine_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_health_id')->unsigned()->nullable();
            $table->foreign('employee_health_id')->references('id')
            ->on('employee_current_health_histories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('vaccine_to',15);
            $table->date('vaccine_date')->nullable();
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
        Schema::dropIfExists('employee_covid19_vaccine_histories');
    }
}
