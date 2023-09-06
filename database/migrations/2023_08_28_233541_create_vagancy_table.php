<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVagancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vagancy', function (Blueprint $table) {
            $table->id();
            $table->string('start_date_time')->nullable();
            $table->string('end_date_time')->nullable();
            $table->string('hour_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('number');
            $table->unsignedBigInteger('cars_id');
            $table->foreign('cars_id')->references('id')->on('cars');
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
        Schema::dropIfExists('vagancy');
    }
}
