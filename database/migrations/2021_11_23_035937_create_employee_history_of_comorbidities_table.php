<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeHistoryOfComorbiditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_history_of_comorbidities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_health_id')->unsigned()->nullable();
            $table->foreign('employee_health_id')->references('id')
            ->on('employee_current_health_histories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('history_of_comorbidities',50)->nullable();
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
        Schema::dropIfExists('employee_history_of_comorbidities');
    }
}
