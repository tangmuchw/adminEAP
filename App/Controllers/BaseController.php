<?php
namespace App\Controllers;

use \interop\Container\ContainerInterface as ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\BaseModel;

class BaseController {

	protected $container;

	public function __construct(ContainerInterface $ci) 
	{
		$this -> container = $ci;
	}
	
	public function Error(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/404.html';
	}
	
	public function myselfInfo(Request $request,Response $response, $args) 
	{
		$email = $_SESSION['UserName'];
		$base = new BaseModel();
		$result = $base-> getMyselfInfo($email);
		return $response -> withJson($result);
	}

}
?>