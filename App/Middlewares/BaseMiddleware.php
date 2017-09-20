<?php

namespace App\Middlewares;

use \interop\Container\ContainerInterface as ContainerInterface;

class BaseMiddleware
{
	protected $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
}	
?>