<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaystackInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystack_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('currency',5)->default("GHS");
            $table->decimal('amount',16,2);
            $table->string('status',25)->default('pending');
            $table->boolean('paid')->default(false);
            $table->integer('reservation_id')->nullable();
            $table->integer('customer');
            $table->integer('integration');
            $table->integer('invoice_id');
            $table->integer('invoice_number');
            $table->string('request_code',100);
            $table->string('paid_at',150)->nullable();
            $table->string('metadata',100)->nullable();
            $table->string('offline_reference',120)->nullable();
            $table->string('split_code')->nullable();
            $table->string('domain',100)->nullable();
            $table->text('line_items');
            $table->text('tax')->nullable();
            $table->decimal('discount',16,2)->nullable();
            $table->dateTime('due_date')->nullable();
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
        Schema::dropIfExists('paystack_invoices');
    }
}
