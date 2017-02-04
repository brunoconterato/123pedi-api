<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('client_id')->unsigned()->default();
			$table->foreign('client_id')->references('id')->on('users');

			$table->integer('retailer_id')->unsigned()->nullable();
			$table->foreign('retailer_id')->references('id')->on('users');

			$table->decimal('total')->default(0);
			$table->string('status')->default(0);
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
		Schema::drop('orders');
	}

}
