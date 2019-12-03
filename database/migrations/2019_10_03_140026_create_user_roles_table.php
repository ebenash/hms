<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default roles
        DB::table('user_roles')->insert([
            ['role_name' => 'Administrator','created_at' => date("Y-m-d H:i:s")],
            ['role_name' => 'Editor','created_at' => date("Y-m-d H:i:s")],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
