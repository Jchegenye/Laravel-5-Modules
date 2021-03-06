<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            
            $table->string('username');
            $table->string('role');
            $table->string('signed_date');
            $table->string('confirmation_code');
            $table->string('verification_token');
            
            $table->rememberToken();
            $table->timestamps();
            //$table->string('email')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
