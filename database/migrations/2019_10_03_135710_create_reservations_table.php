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
            $table->integer('room_id')->nullable();
            $table->integer('room_type');
            $table->integer('guest_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('days');
            $table->integer('adults');
            $table->integer('children')->nullable();
            $table->string('reservation_status',10)->default('pending');
            $table->decimal('discount',7,2)->nullable();
            $table->string('currency',5)->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->string('payment_method',50)->nullable();
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
