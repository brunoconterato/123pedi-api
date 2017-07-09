<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('retailers', function(Blueprint $table) {
			$table->increments('id');
			//$table->string('name');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->string('cnpj');
			$table->string('phone');
			$table->text('address');
			$table->string('city');
			$table->string('state');
			$table->string('zipcode');

			$table->double('latitude');
			$table->double('longitude');

			$table->smallInteger('delivery_radius');

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
		Schema::drop('retailers');
	}

}
