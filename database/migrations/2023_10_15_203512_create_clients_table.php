<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration
{

    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->unique();
            $table->string('password');
            $table->integer('regoin_id')->unsigned();
            $table->string('image');
            $table->string('remember_me', 100)->nullable();
            $table->string('api_token', 100);
            $table->string('code', 6)->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('clients');
    }
}
