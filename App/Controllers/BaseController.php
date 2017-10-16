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
	
	public function getMyselfInfo(Request $request,Response $response, $args) 
	{
		$email = $_SESSION['UserName'];
		$base = new BaseModel();
		$result = $base-> getMyselfInfo($email);
		return $response -> withJson($result);
	}
	
	public function setMyselfInfo(Request $request,Response $response, $args) 
	{
		$email = $_SESSION['UserName'];
		$name = $request -> getParam('name');
		$phone = $request -> getParam('phone');
		$age = $request -> getParam('age');
		$sex = $request -> getParam('sex');
		$address= $request -> getParam('address');
		$face= $request -> getParam('face');
		$base = new BaseModel();
		$result = $base-> setMyselfInfo($email,$name,$phone,$age,$sex,$address,$face);
		if($result){
			$data = array('msg' => '个人信息修改操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '个人信息修改操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function selfSearch(Request $request,Response $response, $args)
	 {
		$email = $_SESSION['UserName'];
		$base = new BaseModel();
		$result = $base->selfSelect($email);
		return $response -> withJson($result);
	}

}
?>