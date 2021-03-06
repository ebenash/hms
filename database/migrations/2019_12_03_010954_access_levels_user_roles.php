<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccessLevelsUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('access_levels_user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_roles_id');
            $table->integer('access_levels_id');
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
        //
        Schema::dropIfExists('access_levels_user_roles');
    }
}
