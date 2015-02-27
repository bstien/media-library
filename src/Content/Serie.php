<?php
namespace Stien\MediaLibrary\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serie extends Eloquent {

	protected $table = 'medialibrary_series';
	protected $guarded = ['id'];
	protected $fillable = ['imdb_id', 'name', 'overview', 'status', 'banner', 'fan_art', 'poster'];


	/**
	 * Define the relationship to Episode
	 *
	 * @return HasMany
	 */
	public function episodes()
	{
		return $this->hasMany('Stien\MediaLibrary\Content\Episode');
	}

	/**
	 * Make the title search-friendly and easy to
	 * append to episode-titles for files.
	 *
	 * @return string
	 */
	public function formatName()
	{
		// Replace all spaces with '.'.
		$name = preg_replace('/ /', '.', $this->name);

		// Remove certain characters.
		$name = preg_replace('/[\(\)]/', '', $name);

		return $name;
	}

}