<?php
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\UserModel;
use stdClass;

class 	UserController extends BaseController
{
	
	
	public function UserList(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/user/list.html';

	}
	
	public function UserIndex(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/user/index.html';

	}
	public function UserItem(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/user/item.html';

	}
	
	public function postLogin(Request $request,Response $response,$args)
	{
		$username = $request -> getParam('email');
		$password = $request -> getParam('pwd');
		$remember = $request -> getParam('remember');
		$user = new UserModel();
		if($user -> getUserInfo($username,$password)){
			$index = $user -> getUserToRole($username);
			$_SESSION['UserName'] = $username;
			$data = array('msg' => '登录成功', 'code' => '1','index' => $index[roleId]);
		}else{
			$data = array('msg' => '邮箱或者密码错误', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function Login(Request $request,Response $response,$args)
	{
			include APP_PATH . '/Views/User/login.html';
	}
	
	public function Logout($request, $response, $args) {
		unset($_SESSION["UserName"]);
		include APP_PATH . '/Views/User/Login.html';
	}
	
	public function UserInfo(Request $request,Response $response, $args) 
	{
		
		$user = new UserModel();
		$result = $user->getUserFullInfo();
//		var_dump($result);
		
		/*for($i=0 ; $i<count($result); $i++){
			$result[$i]['btn'] = "<button type='button' class='btn btn-default delete-btn' data-toggle='modal' >删除</button>"; 
		}*/
		$start = $_GET["start"];
		//表可以在当前绘图中显示的记录数。
		$length = $_GET["length"];
		$draw = $_GET["draw"];
		//应该应用排序的列。这是columns也提交给服务器的信息数组的索引引用。
		$col = $_GET["order"][0]["column"];
		//此列的订购方向。升序或降序,排序方式
		$dir = $_GET["order"][0]["dir"];
		//全局搜索值。
		$search = $_GET["search"];
		$newarr = new stdClass();
		$newarr->draw = $draw;
		$newarr->page = (int)(count($result)/$length);
		$newarr->recordsTotal =count($result);
		$newarr->recordsFiltered = 100;
		$newarr->data = array();

		$h=0;
		for($i = $start; $i<$start+$length;$i++,$h++)
		{
			$newarr->data[$h] = $result[$i];
		}
		return $response->withJson($newarr);
//		echo json_encode($newarr);
//		echo "UserInfo";
	}
	
	public function UserAdd(Request $request,Response $response, $args) {
		$newUserName =$request -> getParam('newUserName');
		$newPwd = $request -> getParam('newPwd');
		$newEmail = $request -> getParam('newEmail');
		$user = new UserModel();
		if($user -> addNewUser($newUserName,$newPwd,$newEmail)){
			$data = array('msg' => '新增用户成功', 'code' => '1');
		}else{
			$data = array('msg' => '新增用户失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function UserDelete(Request $request,Response $response, $args) {
		$email = $request -> getParam('email');
		$user = new UserModel();
		if($user -> deleteUSer($email)){
			$data = array('msg' => '删除操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '删除操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function UserSelect(Request $request,Response $response, $args) {
		
		$searchValue = $request -> getParam('searchValue');
		$user = new UserModel();
		$result = $user -> selectUser($searchValue);
//		var_dump($result);
//		var_dump($start);
//		var_dump($length);
//		var_dump($draw);
//		var_dump($result);
//		var_dump(count($result));
		$newarr = new stdClass();
		$newarr->page = (int)(count($result)/10)<10?1:(int)(count($result)/$length);
		$newarr->recordsTotal =count($result);
		$newarr->recordsFiltered = count($result);
		$newarr->data = array();
		$h=0;
		for($i = 0; $i<count($result);$i++,$h++)
		{
			$newarr->data[$h] = $result[$i];
		}
//		var_dump($newarr);

		return $response->withJson($newarr);
	}
	
	public function UserUpdate(Request $request,Response $response, $args) {
		$email = $request -> getParam('email');
		$state = $request -> getParam('state');
		$user = new UserModel();
		if($user -> updateUser($email,$state)){
			$data = array('msg' => '修改操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '修改操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	
	
}
?>