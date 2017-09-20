<?php
namespace App\Middlewares;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//中间件
class TrailingSlashMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response,$next)
	{
		$uri = $request -> getUri();
		$path = $uri -> getPath();
		if($path != '/' && substr($path,-1) == '/'){
			$uri = $uri -> withPath(substr($path,0,-1));
			return $response -> withRedirect((string)$uri,301);
		}
		
		return $next($request,$response);
	}
}	
?>