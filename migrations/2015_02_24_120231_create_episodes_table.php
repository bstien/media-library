<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medialibrary_episodes', function(Blueprint $t)
		{
			$t->integer('id')->unsigned();
			$t->integer('number')->unsigned();
			$t->integer('season')->unsigned();

			// References
			$t->integer('serie_id')->unsigned();
			$t->string('imdb_id');

			$t->string('name');
			$t->text('overview');
			$t->date('first_aired')->nullable();

			$t->boolean('is_downloaded');
			$t->string('thumbnail');

			$t->timestamps();


			$t->primary('id');
			$t->foreign('serie_id')
				->references('id')
				->on('medialibrary_series')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('medialibrary_episodes');
	}

}
