<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\RoleModel;
use stdClass;

class RoleController extends UserController
{
	public function RoleIndex(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/role/index.html';
	}
	
	public function RoleList(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/role/list.html';
	}
	
	
	
	
	
}
?>