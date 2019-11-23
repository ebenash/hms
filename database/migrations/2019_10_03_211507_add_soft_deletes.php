<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function ($table) {
            $table->softDeletes();
        });

        Schema::table('guests', function ($table) {
            $table->softDeletes();
        });

        Schema::table('room_types', function ($table) {
            $table->softDeletes();
        });

        Schema::table('reservations', function ($table) {
            $table->softDeletes();
        });

        Schema::table('rooms', function ($table) {
            $table->softDeletes();
        });

        Schema::table('payments', function ($table) {
            $table->softDeletes();
        });

        Schema::table('migrations', function ($table) {
            $table->softDeletes();
        });

        Schema::table('password_resets', function ($table) {
            $table->softDeletes();
        });

        Schema::table('user_roles', function ($table) {
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
        //
    }
}
