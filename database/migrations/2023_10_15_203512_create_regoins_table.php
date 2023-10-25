<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegoinsTable extends Migration
{

    public function up()
    {
        Schema::create('regoins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('city_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('regoins');
    }
}