<?php
namespace Stien\MediaLibrary\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;
use Moinax\TvDb\Episode as TvDbEpisode;

class Episode extends Eloquent {

	protected $table = 'medialibrary_episodes';
	protected $guarded = ['id'];
	protected $fillable = ['number', 'season', 'serie_id', 'imdb_id', 'name', 'overview', 'first_aired', 'is_downloaded', 'thumbnail'];

	public static function createFromTvDbEpisode(TvDbEpisode $e)
	{
		// If season is 0 or less, this is a special episode.
		// Most likely not aired or special material on DVD.
		if ( $e->season < 1 ) return;

		// Create or find Episode based on id.
		$episode = Episode::find($e->id);
		if ( ! $episode )
		{
			$episode = new Episode();
			$episode->id = $e->id;
		}

		// Make all public attributes snakecase.
		// If the key does not exist in $fillable-array,
		// it will not be related to the object.
		$information = [];
		foreach ($e as $k => $v)
		{
			$k = Str::snake($k);
			$information[$k] = $v;
		}

		$episode->fill($information);
		$episode->save();

		return $episode;
	}

	public function serie()
	{
		return $this->belongsTo('Stien\MediaLibrary\Content\Serie');
	}
}