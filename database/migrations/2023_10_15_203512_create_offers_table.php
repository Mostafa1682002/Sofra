<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration
{

    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('discription');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('image');
            $table->integer('restaurant_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('offers');
    }
}