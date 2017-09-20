<?php
namespace App\Middlewares;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

	/*
	 * 身份认证中间证
	 */
	
//	登录状态认证
class AuthMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request,Response $response,$next)
	{
//		未登录状态，页面跳到登录页面
		if($_SESSION['UserName'] == null){
			return $response -> withRedirect($this -> container -> router -> pathFor('Login'));
//			$response = $next($request,$response);
//			return $response -> withRedirect('/login');
		}
		$response = $next($request,$response);
//			return $response -> withRedirect($this -> container -> router -> pathFor('Login'));

		return $response;
	}
}

?>