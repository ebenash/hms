<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider',50);
            $table->string('currency',5);
            $table->decimal('amount',16,2);
            $table->string('status',25)->default('pending');
            $table->integer('reservation_id');
            $table->string('authorization_url')->nullable();
            $table->string('access_code',100)->nullable();
            $table->string('reference',100)->nullable();
            $table->string('transaction_date',120)->nullable();
            $table->string('message')->nullable();
            $table->string('domain',100)->nullable();
            $table->string('channel',100)->nullable();
            $table->string('gateway_response')->nullable();
            $table->string('ip_address',100)->nullable();
            $table->text('log')->nullable();
            $table->text('authorization')->nullable();
            $table->text('customer')->nullable();
            $table->string('plan')->nullable();
            $table->string('fees',25)->nullable();
            $table->decimal('requested_amount',16,2)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
