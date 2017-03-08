<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnregisteredOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unregistered_orders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('phone');
            $table->string('street_adress');
            $table->string('adress_line_2');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->string('email');

            $table->decimal('lat_coordinate');
            $table->decimal('long_coordinate');

            $table->integer('retailer_id');

            $table->decimal('total')->default(0);
            $table->string('status')->default("Pendente");

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
        Schema::dropIfExists('unregistered_orders');
    }
}
