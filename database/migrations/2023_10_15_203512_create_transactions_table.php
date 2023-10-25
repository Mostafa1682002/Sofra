<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration
{

    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount');
            $table->text('notes')->nullable();
            $table->integer('restaurant_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('transactions');
    }
}