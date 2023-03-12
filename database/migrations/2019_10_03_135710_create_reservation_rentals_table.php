<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_rentals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reservations_id');
            $table->string('rental_type',10);
            $table->string('description',250);
            $table->decimal('price',15,2);
            $table->integer('quantity');
            $table->decimal('total_price',15,2);
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
        Schema::dropIfExists('reservation_rentals');
    }
}
