<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMppNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpp_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->string('application_code');
            $table->string('application_name');
            $table->text('application_host');
            $table->unsignedBigInteger('information_id');
            $table->string('notification_title');
            $table->text('notification_body');
            $table->string('notification_url');
            $table->timestamps();

            // $table->foreign('information_id')->references('id')->on('mpp_informations');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpp_notifications');
    }
}