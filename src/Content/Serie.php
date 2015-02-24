<?php
namespace Stien\MediaLibrary\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Moinax\TvDb\Serie as TvDbSerie;

class Serie extends Eloquent {

	protected $table = 'medialibrary_series';
	protected $guarded = ['id'];
	protected $fillable = ['imdb_id', 'name', 'overview', 'status', 'banner', 'fan_art', 'poster'];

	/**
	 * Create new Eloquent-object from TvDbSerie.
	 *
	 * @param TvDbSerie $s
	 * @return Serie
	 */
	public static function createFromTVDbSerie(TvDbSerie $s)
	{
		// Create or find Serie based on id.
		$serie = Serie::find($s->id);
		if ( ! $serie )
		{
			$serie = new Serie();
			$serie->id = $s->id;
		}


		// Make all public attributes snakecase.
		// If the key does not exist in $fillable-array,
		// it will not be related to the object.
		$information = [];
		foreach ($s as $k => $v)
		{
			$k = Str::snake($k);
			$information[$k] = $v;
		}

		// Fill the object, save and return it.
		$serie->fill($information);
		$serie->save();

		return $serie;
	}

	/**
	 * @return HasMany
	 */
	public function episodes()
	{
		return $this->hasMany('Stien\MediaLibrary\Content\Episode');
	}
}