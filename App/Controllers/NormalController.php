<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class NormalController extends BaseController
{
	
	public function NormalIndex(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/normal/index.html';
	}
	
	public function NormalSelf(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/normal/self.html';
	}
	
}
?>