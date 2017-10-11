<?php
namespace App\Middlewares;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\UserModel;	

//角色的访问权限
class RoleMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request,Response $response,$next)
	{
		$urlpath = $request -> getUri() -> getPath();
		
		$user = new UserModel();
		$ret = $user -> getUserRoleToPower($_SESSION['UserName'],$urlpath);
//		var_dump($ret);

		if($ret == 0){
			//没有权限访问该资源
			return $response -> withRedirect($this -> container ->router-> pathFor('Error'));
//			return $response -> withRedirect('/404');
		}else{
			$response = $next($request,$response);
			
		}
		//验证是否具备访问权限
		
		return $response;
	}
}

?>