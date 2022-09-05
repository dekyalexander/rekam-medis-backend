<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('unit_type_id');
            $table->unsignedBigInteger('type_activity_id');
            $table->unsignedBigInteger('occupation_id');
            $table->string('position',191);
            $table->text('reason');
            $table->text('assignment');
            $table->text('requirements');
            $table->text('support_file');
            $table->integer('status_approval');
            $table->unsignedBigInteger('user_created');
            $table->timestamps();

            // $table->foreign('unit_id')->references('id')->on('units');
            // $table->foreign('unit_type_id')->references('id')->on('unit_types');
            // $table->foreign('type_activity_id')->references('id')->on('mpp_type_activities');
            // $table->foreign('user_created')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpp');
    }
}
