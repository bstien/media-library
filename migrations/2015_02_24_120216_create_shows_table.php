<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medialibrary_series', function(Blueprint $t)
		{
			$t->integer('id')->unsigned();

			$t->string('imdb_id');

			$t->string('name');
			$t->string('overview');
			$t->string('status');

			$t->string('banner');
			$t->string('fan_art');
			$t->string('poster');

			$t->timestamps();

			$t->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('medialibrary_series');
	}

}
