<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpenIntervalsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('open_intervals', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('retailer_id')->unsigned();
			$table->foreign('retailer_id')->references('id')->on('retailers');

			$table->unsignedSmallInteger('day_of_week')->unsigned();  //De 1 (Segunda) a 7(Domingo) ???

			$table->time('start_time');
        	$table->time('end_time');

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
		Schema::drop('open_intervals');
	}

}
