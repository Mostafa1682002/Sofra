<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration
{

    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->unique();
            $table->integer('regoin_id')->unsigned();
            $table->float('minimum_order');
            $table->float('delivary_cost');
            $table->string('whatsapp', 20);
            $table->string('image');
            $table->boolean('status')->default(1);
            $table->boolean('active')->default(1);
            $table->string('remember_me', 100)->nullable();
            $table->string('api_token', 100);
            $table->string('code', 6)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('restaurants');
    }
}
