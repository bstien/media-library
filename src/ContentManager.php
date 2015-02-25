<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use League\Flysystem\Filesystem;

class ContentManager {

	/**
	 * @var ConfigRepository
	 */
	private $config;

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
}