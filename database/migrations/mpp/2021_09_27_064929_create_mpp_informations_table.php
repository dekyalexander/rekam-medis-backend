<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMppInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpp_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tahun_pelajaran',191);
            $table->dateTime('validity_period_from');
            $table->dateTime('validity_period_until');
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->string('notif_description',191)->nullable();
            $table->boolean('publish');
            $table->unsignedInteger('user_created_id');
            $table->timestamps();

            // $table->foreign('user_created_id')->references('id')->on('users');
            //diatas sementara tutup kalau sudah live baru buka.

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpp_informations');
    }
}
