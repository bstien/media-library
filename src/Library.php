<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Stien\MediaLibrary\TvDb\TvDbManager;

class Library {

	/**
	 * @var ConfigRepository
	 */
	protected $config;

	/**
	 * @var ContentManager
	 */
	protected $contentManager;

	/**
	 * @var TvDbManager
	 */
	protected $tvDbManager;

	function __construct(ConfigRepository $config)
	{
		$this->config = $config;
	}

	/**
	 * @return ContentManager
	 */
	public function getContentManager()
	{
		return $this->contentManager;
	}

	/**
	 * @param ContentManager $contentManager
	 */
	public function setContentManager($contentManager)
	{
		$this->contentManager = $contentManager;
	}
}