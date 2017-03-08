<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

			$table->integer('quantity');
			$table->integer('unregistered_order_id');

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
