<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            
            $table->bigInteger('drug_id')->unsigned();
            $table->foreign('drug_id')->references('id')
            ->on('drugs')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->bigInteger('location_id')->unsigned();
            $table->foreign('location_id')->references('id')
            ->on('location_drugs')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->bigInteger('drug_expired_id')->unsigned();
            $table->foreign('drug_expired_id')->references('id')
            ->on('drug_expireds')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('stocks');
    }
}
