<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\UserModel;
use stdClass;

class NormalController extends BaseController
{
	
	public function PersonIndex(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/person/index.html';
	}
	
	
}
?>