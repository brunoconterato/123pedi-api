<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_items', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products');

			$table->integer('retailer_id')->unsigned();
			$table->foreign('retailer_id')->references('id')->on('petshops');

			$table->integer('quantity');
			$table->date('expiration_date');

			$table->decimal('price');
			$table->decimal('min_selling_price')->default(0);
			$table->decimal('cost_price')->default(0);

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
		Schema::drop('stock_items');
	}

}
