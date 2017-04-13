<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMessageGettersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_message_getters', function(Blueprint $table) {
            $table->increments('id');

			$table->string('name')->default("NoName");
			$table->string('phone')->default("NoPhone");
			$table->string('email')->default("NoEmail");

			$table->string('message');

			$table->string('latitude')->default("NoLatitude");
			$table->string('longitude')->default("NoLongitude");

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
		Schema::drop('user_message_getters');
	}

}
