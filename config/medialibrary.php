<?php
return [
	/**
	 * Absolute path to your library.
	 */
	'library_path' => '',

	/**
	 * Your API-key to TheTVDB.com.
	 * A key can be requested here:
	 * http://thetvdb.com/?tab=apiregister
	 */
	'tvdb_api_key' => '',

	/**
	 * Uncomment to set cache-path manually.
	 * Defaults to <code>[app_root]/storage/cache/tvdb</code>
	 */
	#'tvdb_cache_path' => '',

	/**
	 * Uncomment to set time-to-live on cache manually.
	 * Defaults to one week. 86400 * 7.
	 */
	# 'tvdb_cache_ttl' => '',


	/**
	 * Don't change this unless the service changes domain.
	 */
	'tvdb_base_url' => 'http://thetvdb.com',
];