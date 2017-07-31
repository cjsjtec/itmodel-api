<?php

namespace App\Repositories;

use Lab123\Odin\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository 
{
	public function getBuilder()
	{
		return $this->builder;
	}
}