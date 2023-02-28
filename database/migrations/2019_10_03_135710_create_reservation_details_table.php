<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reservations_id');
            $table->integer('room_id')->nullable();
            $table->integer('room_type_id');
            $table->integer('adults');
            $table->integer('children')->nullable();
            $table->decimal('price_per_day',15,2)->nullable();
            $table->decimal('total_price',15,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('reservations_id');
            $table->index('room_type_id');
            $table->index('room_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_details');
    }
}
