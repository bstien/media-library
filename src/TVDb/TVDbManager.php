<?php
namespace Stien\MediaLibrary\TvDb;

use Moinax\TvDb\Client;
use Moinax\TvDb\Http\CacheClient;
use Moinax\TvDb\Http\Cache\FilesystemCache;

class TvDbManager {

	private $client;

	/**
	 * @param      $baseUrl
	 * @param      $apiKey
	 * @param null $cachePath
	 * @param null $cacheTtl
	 */
	public function __construct($baseUrl, $apiKey, $cachePath = null, $cacheTtl = null)
	{
		$this->client = new Client($baseUrl, $apiKey);

		if($cachePath != null && is_string($cachePath)){

			// Set default cache TTL to one week.
			($cacheTtl != null && is_int($cacheTtl))? $cacheTtl : 86400 * 7;

			// Create cache client and assign it to TvDb-client
			$cache = new FilesystemCache($cachePath);
			$httpClient = new CacheClient($cache, $cacheTtl);
			$this->client->setHttpClient($httpClient);
		}
	}
}