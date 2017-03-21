<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnregisteredOrderItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unregistered_order_items', function(Blueprint $table) {
            $table->increments('id');

			$table->smallInteger('quantity');

			$table->integer('stockItem_id')->unsigned();
			$table->foreign('stockItem_id')->references('id')->on('stock_items');

			$table->integer('unregistered_order_id')->unsigned();
			$table->foreign('unregistered_order_id')->references('id')->on('unregistered_orders');

            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('unregistered_order_items');
	}

}
