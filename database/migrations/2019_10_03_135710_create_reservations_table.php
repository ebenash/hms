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
            $table->integer('guest_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('days');
            $table->string('reservation_status',10)->default('pending');
            $table->string('currency',5)->nullable();
            $table->decimal('grand_total',15,2)->nullable();
            $table->decimal('amount_paid',7,2)->nullable();
            $table->decimal('balance',7,2)->nullable();
            $table->string('payment_method',50)->nullable();
            $table->string('invoice_sent',5)->default(false);
            $table->string('paid',5)->default("pending");
            $table->text('notes')->nullable();
            $table->string('vat_invoice_number')->nullable();
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
