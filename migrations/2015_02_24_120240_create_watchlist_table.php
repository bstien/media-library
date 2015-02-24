<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchlistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medialibrary_watchlist', function(Blueprint $t)
		{
			$t->integer('id')->unsigned();

			$t->primary('id');
			$t->foreign('id')
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
		Schema::drop('medialibrary_watchlist');
	}

}
