<?php
namespace Stien\MediaLibrary;

use Illuminate\Contracts\Config\Repository;

class Library {
	protected $config;

	function __construct(Repository $config)
	{
		$this->config = $config;
	}
}