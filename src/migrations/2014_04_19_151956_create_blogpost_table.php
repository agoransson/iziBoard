<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogpostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blogposts', function($table){

			$table->increments('id');
			$table->string('title');

			$table->integer('blogpostable_id');
			$table->string('blogpostable_type');

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
		Schema::dropIfExists('blogposts');
	}

}
