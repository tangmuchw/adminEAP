<?php
namespace App\Controllers;

use \interop\Container\ContainerInterface as ContainerInterface;

class BaseController {

	protected $container;

	public function __construct(ContainerInterface $ci) {
		$this -> container = $ci;
	}
	
	public function Error(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/404.html';
	}
	

}
?>