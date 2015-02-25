<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use League\Flysystem\Filesystem;
use Stien\MediaLibrary\TvDb\TvDbManager;

class ContentManager {

	/**
	 * @var ConfigRepository
	 */
	protected $config;

	/**
	 * @var TvDbManager
	 */
	protected $tvDbManager;

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
	 * @return TvDbManager
	 */
	public function getTvDbManager()
	{
		return $this->tvDbManager;
	}

	/**
	 * @param TvDbManager $tvDbManager
	 */
	public function setTvDbManager($tvDbManager)
	{
		$this->tvDbManager = $tvDbManager;
	}


}