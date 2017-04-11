<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemGettersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart_item_getters', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('stock_item_id');
			$table->foreign('stock_item_id')->references('id')->on('stock_items');

			$table->integer('quantity');
			$table->string('latutude')->default('none');
			$table->string('longitude')->default('none');
			
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
		Schema::drop('cart_item_getters');
	}

}
