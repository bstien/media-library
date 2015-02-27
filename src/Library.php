<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository as ConfigRepository;

class Library {

	/**
	 * @var ConfigRepository
	 */
	protected $config;

	/**
	 * @var ContentManager
	 */
	protected $contentManager;

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