<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support;
use Illuminate\Support\Facades\App;
use Stien\MediaLibrary\TvDb\TvDbManager;

class Library {

	protected $config;
	protected $tvdb_client;

	function __construct(Repository $config)
	{
		$this->config = $config;


		// Set up TvDbManager
		$this->setupTvDbClient();
	}

	private function setupTvDbClient()
	{
		// Set API-key
		$apiKey = $this->config['medialibrary']['tvdb_api_key'];

		// Set base URL for TvDb-Client
		$baseUrl = $this->config['medialibrary']['tvdb_base_url'];

		// Set cache-path.
		$cachePath = $this->config['medialibrary']['tvdb_cache_path'];
		if ( ! isset($cachePath) || ! is_string($cachePath) )
		{
			$cachePath = App::storagePath() . "/cache/tvdb/";
		}

		// Set cache-TTL.
		$cacheTtl = $this->config['medialibrary']['tvdb_cache_ttl'];
		if ( ! isset($cacheTtl) || $cacheTtl <= 0 )
		{
			// Defaults to one week. Suits us fine.
			$cacheTtl = null;
		}

		$this->tvdb_client = new TvDbManager($baseUrl, $apiKey, $cachePath, $cacheTtl);
	}
}