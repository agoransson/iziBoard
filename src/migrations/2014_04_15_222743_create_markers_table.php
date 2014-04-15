<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('markers', function($table){

			$table->increments('id');
	
			$table->string('title');
			$table->text('description');
			$table->string('latitude');
			$table->string('longitude');

			$table->integer('markerable_id');
			$table->string('markerable_type');

			$table->timestamps();
			$table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('markers');
	}

}
