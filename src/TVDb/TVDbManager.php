<?php
namespace Stien\MediaLibrary\TvDb;

use Moinax\TvDb\Client;
use Moinax\TvDb\Http\Cache\FilesystemCache;
use Moinax\TvDb\Http\CacheClient;
use Stien\MediaLibrary\Content\Episode;
use Stien\MediaLibrary\Content\Serie;
use Stien\MediaLibrary\ContentManager;

class TvDbManager extends Client {

	/**
	 * @param      $baseUrl
	 * @param      $apiKey
	 * @param null $cachePath
	 * @param null $cacheTtl
	 */
	public function __construct($baseUrl, $apiKey, $cachePath = null, $cacheTtl = null)
	{
		parent::__construct($baseUrl, $apiKey);

		if ( $cachePath != null && is_string($cachePath) )
		{
			// Set default cache TTL to one week.
			($cacheTtl != null && is_int($cacheTtl)) ? $cacheTtl : 86400 * 7;

			// Create cache client and assign it to TvDb-client
			$cache = new FilesystemCache($cachePath);
			$httpClient = new CacheClient($cache, $cacheTtl);
			$this->setHttpClient($httpClient);
		}
	}

	/**
	 * Create or update serie- and episode-information in database
	 * based on ID from TheTVDb.com.
	 *
	 * @param $id int The ID from TVDb.com
	 * @throws \ErrorException
	 */
	public function createOrUpdate($id)
	{
		$res = $this->getSerieEpisodes($id);
		if ( $res )
		{
			Serie::createFromTVDbSerie($res['serie']);
			foreach ($res['episodes'] as $e)
			{
				Episode::createFromTvDbEpisode($e);
			}
		}
	}

	public function setContentManager(ContentManager $contentManager)
	{

	}
}