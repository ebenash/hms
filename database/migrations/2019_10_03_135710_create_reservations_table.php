<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('room_id');
            $table->integer('guest_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('adults');
            $table->integer('children')->nullable();
            $table->integer('reservation_status');
            $table->decimal('discount',7,2);
            $table->decimal('price',15,2);
            $table->integer('company_id');
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
