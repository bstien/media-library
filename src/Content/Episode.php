<?php
namespace Stien\MediaLibrary\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Eloquent {

	protected $table = 'medialibrary_episodes';
	protected $guarded = ['id'];
	protected $fillable = ['number', 'season', 'serie_id', 'imdb_id', 'name', 'overview', 'first_aired', 'is_downloaded', 'thumbnail'];


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