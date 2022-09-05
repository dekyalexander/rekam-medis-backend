<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCurrentHealthHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_current_health_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('nik',10)->nullable();
            $table->string('unit',20)->nullable();
            $table->string('blood_group',10);
            $table->string('blood_group_rhesus',10)->nullable();
            $table->string('basic_immunization',20);
            $table->string('history_of_drug_allergy',50)->nullable();
            $table->string('covid19_illness_history',10);
            $table->date('covid19_sick_date')->nullable();
            $table->string('covid19_vaccine_history',10);
            $table->text('covid19_vaccine_description')->nullable();
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
        Schema::dropIfExists('employee_current_health_histories');
    }
}
