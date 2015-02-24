<?php
namespace Stien\MediaLibrary\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Moinax\TvDb\Episode as TvDbEpisode;

class Episode extends Eloquent {

	protected $table = 'medialibrary_episodes';
	protected $guarded = ['id'];
	protected $fillable = ['number', 'season', 'serie_id', 'imdb_id', 'name', 'overview', 'first_aired', 'is_downloaded', 'thumbnail'];

	/**
	 * Create or update an episode in database from TvDbEpisode.
	 *
	 * @param TvDbEpisode $e
	 * @return Episode
	 */
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


	/**
	 * Define the relationship to Serie
	 *
	 * @return BelongsTo
	 */
	public function serie()
	{
		return $this->belongsTo('Stien\MediaLibrary\Content\Serie');
	}

	/**
	 * Get the relative path where the file should be stored from
	 * the library root.
	 *
	 * Format: 'Serie Name/01/[SerieName.S01E01]'
	 * Filename is prepended if <code>$withFilename</code> is true.
	 *
	 * @param bool $withFilename Should the filename be included?
	 * @return string The relative path from library_root
	 */
	public function getRelativePath($withFilename = false)
	{
		$serie = $this->serie->name;
		$season = ($this->season >= 10 ? $this->season : '0' . $this->season);

		return $serie . '/' . $season . '/' . ($withFilename ? $this->getFilename() : '');
	}

	/**
	 * Get the files name, without extension.
	 *
	 * Format: SerieName.S01E01
	 *
	 * @return string
	 */
	public function getFilename()
	{
		$serie = $this->serie;
		$season = ($this->season >= 10 ? $this->season : '0' . $this->season);
		$episode = ($this->number >= 10 ? $this->number : '0' . $this->number);

		return $serie->getDottedName() . '.S' . $season . 'E' . $episode;
	}
}