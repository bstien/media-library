<?php
namespace Stien\MediaLibrary\Facades;

use Illuminate\Support\Facades\Facade;

class Library extends Facade{

	protected static function getFacadeAccessor()
	{
		return 'bstien.library';
	}

}