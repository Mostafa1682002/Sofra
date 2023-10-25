<?php

use App\Mostafa\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('notes')->nullable();
            $table->integer('client_id')->unsigned();
            $table->float('cost')->default(0.0);
            $table->float('delivary_cost')->default(0.0);
            $table->float('total_cost')->default(0.0);
            $table->integer('payment_type_id')->unsigned();
            $table->tinyInteger('status')->default(Status::PENDING->value);
            // $table->integer('status')->default(0);
            // 'pending', 'accepted', 'rejected', 'canceled','delivered'
            $table->string('address');
            $table->integer('restaurant_id')->unsigned();
            $table->float('commission')->default(0.0);
            $table->boolean('confirmed_by_client')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('orders');
    }
}
