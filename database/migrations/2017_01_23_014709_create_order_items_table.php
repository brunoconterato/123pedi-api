<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('stockItem_id')->unsigned();
			$table->foreign('stockItem_id')->references('id')->on('stock_items');

			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders');

			$table->decimal('price');
			$table->smallInteger('quantity');

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
		Schema::drop('order_items');
	}

}
