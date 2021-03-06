<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Facades\App;
use Stien\MediaLibrary\TvDb\TvDbManager;

class Library {

	/**
	 * @var ConfigRepository
	 */
	protected $config;

	/**
	 * @var TvDbManager
	 */
	protected $tvdb_manager;

	function __construct(ConfigRepository $config)
	{
		$this->config = $config;

		// Set up TvDbManager
		$this->setupTvDbManager();
	}

	/**
	 * Set up the TvDbManager.
	 */
	private function setupTvDbManager()
	{
		// Set API-key
		$apiKey = $this->config['medialibrary']['tvdb_api_key'];

		// Set base URL for TvDb-Client
		$baseUrl = $this->config['medialibrary']['tvdb_base_url'];

		// Set cache-path.
		$cachePath = ! isset($this->config['medialibrary']['tvdb_cache_path']) ? App::storagePath() . "/cache/tvdb/" : $this->config['medialibrary']['tvdb_cache_path'];

		// Set cache-TTL.
		$cacheTtl = ! isset($this->config['medialibrary']['tvdb_cache_ttl']) ? null : $this->config['medialibrary']['tvdb_cache_ttl'];

		$this->tvdb_manager = new TvDbManager($baseUrl, $apiKey, $cachePath, $cacheTtl);
	}

	/**
	 * @return TvDbManager
	 */
	public function tvdb()
	{
		return $this->tvdb_manager;
	}
}