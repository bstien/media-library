<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Str;
use League\Flysystem\Filesystem;
use Moinax\TvDb\Episode as TvDbEpisode;
use Moinax\TvDb\Serie as TvDbSerie;
use Stien\MediaLibrary\Content\Episode;
use Stien\MediaLibrary\Content\Serie;

class ContentManager {

	/**
	 * @var ConfigRepository
	 */
	protected $config;

	/**
	 * Represents the folder/structure where
	 * the library root is located.
	 *
	 * @var Filesystem
	 */
	private $filesystem;

	public function __construct(ConfigRepository $config, Filesystem $filesystem)
	{
		$this->config = $config;
		$this->filesystem = $filesystem;
	}

	/**
	 * Create or update a serie in database from TvDbSerie.
	 *
	 * @param TvDbSerie $s
	 * @return Serie
	 */
	public function addSerie(TvDbSerie $s)
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
	 * Create or update an episode in database from TvDbEpisode.
	 *
	 * @param TvDbEpisode $e
	 * @return Episode
	 */
	public function addEpisode(TvDbEpisode $e)
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

		// Check for existence in library
		$information['is_downloaded'] = $this->filesystem->has($episode->getRelativePath(true));


		$episode->save();

		return $episode;
	}
}