<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_order_id');
            $table->integer('area_id')->unsigned();
            $table->integer('orderstatus_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('total');
            $table->string('address');
            $table->integer('payment_method')->unsigned();
            $table->timestamps();
            $table->text('note')->nullable();
            $table->float('journey_kms')->nullable();
            $table->float('service_fee')->nullable();
            $table->float('shipping_charges')->nullable();
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
        Schema::drop('orders');
    }
}
