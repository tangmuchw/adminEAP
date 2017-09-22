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
	
	public function RoleUserList(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/role/userList.html';
	}

	public function RoleList(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/role/list.html';
	}

	public function RoleSelf(Request $request,Response $response,$args)
	{
		include APP_PATH.'/Views/role/self.html';
	}

	public function RoleInfo(Request $request,Response $response,$args)
	{
		$role = new RoleModel();
		$result = $role->getRoleFullInfo();
		// var_dump($result);
		
		/*for($i=0 ; $i<count($result); $i++){
			$result[$i]['btn'] = "<button type='button' class='btn btn-default delete-btn' data-toggle='modal' >删除</button>"; 
		}*/
		$start = $_GET["start"];
		//表可以在当前绘图中显示的记录数。
		// $length = $_GET["length"];
		$draw = $_GET["draw"];
		//应该应用排序的列。这是columns也提交给服务器的信息数组的索引引用。
		$col = $_GET["order"][0]["column"];
		//此列的订购方向。升序或降序,排序方式
		$dir = $_GET["order"][0]["dir"];
		//全局搜索值。
		// $search = $_GET["search"];
		$newarr = new stdClass();
		$newarr->draw = $draw;
		$newarr->page = (int)(count($result)/10)<10?1:(int)(count($result)/$length);
		$newarr->recordsTotal =count($result);
		$newarr->recordsFiltered = count($result);
		$newarr->data = array();

		$h=0;
		for($i = $start; $i<count($result);$i++,$h++)
		{
			$newarr->data[$h] = $result[$i];
		}
		return $response->withJson($newarr);
//		echo json_encode($newarr);
//		echo "UserInfo";
	}
	
	public function RoleFullInfo(Request $request,Response $response,$args)
	{
		$role = new RoleModel();
		$result = $role->getRoleFullInfo();
		
		return $response->withJson($result);
	}
	
	
	public function RoleAdd(Request $request,Response $response, $args) {
		$newRoleName =$request -> getParam('newRoleName');
		$newID = $request -> getParam('newID');
		$role = new RoleModel();
		if($role -> addNewRole($newID,$newRoleName)){
			$data = array('msg' => '新增角色成功', 'code' => '1');
		}else{
			$data = array('msg' => '新增角色失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function RoleDelete(Request $request,Response $response, $args) {
		$roleID = $request -> getParam('roleID');
		$role = new RoleModel();
		if($role -> deleteRole($roleID)){
			$data = array('msg' => '删除操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '删除操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function RoleSelect(Request $request,Response $response, $args) {
		
		$searchValue = $request -> getParam('searchValue');
		$role = new RoleModel();
		$result = $role -> selectUser($searchValue);
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

	public function RoleUpdate(Request $request,Response $response, $args) {
		$rolename = $request -> getParam('rolename');
		$roleID = $request -> getParam('roleID');
		$role = new RoleModel();
		if($role -> updateRole($roleID,$rolename)){
			$data = array('msg' => '修改操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '修改操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}

	public function RoleSelectUserToRole(Request $request,Response $response, $args) {
		$roleID = $request -> getParam('roleID');
		$role = new RoleModel();
		$result = $role ->selectUserToRole($roleID);
		
		// var_dump($result);
		
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
		// $search = $_GET["search"];
		$newarr = new stdClass();
		$newarr->draw = $draw;
		$newarr->page = (int)(count($result)/10)<10?1:(int)(count($result)/$length);
		$newarr->recordsTotal =count($result);
		$newarr->recordsFiltered = count($result);
		$newarr->data = array();


		if(count($result) == 0){
			$length = 0;
		}
		$h=0;
		for($i = $start; $i<$start+$length;$i++,$h++)
		{
			$newarr->data[$h] = $result[$i];
		}
		return $response->withJson($newarr);
//		echo json_encode($newarr);
	}
	
	public function RoleSelectRoleOfUser(Request $request,Response $response, $args) {
		
		$searchUserName = $request -> getParam('searchUserName');
		$role = new RoleModel();
		$result = $role -> selectRoleOfUser($searchUserName);
//		var_dump($result);
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
	
	
	public function RoleRoleOfUserDelete(Request $request,Response $response, $args) {
		$userID = $request -> getParam('UserID');
		$role = new RoleModel();
		if($role -> deleteRoleOfUser($userID)){
			$data = array('msg' => '删除操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '删除操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	public function RoleRoleOfUserAdd(Request $request,Response $response, $args) {
		$UserID = $request -> getParam('UserID');
		$RoleID = $request -> getParam('RoleID');
		$role = new RoleModel();
		if($role -> addRoleOfUser($UserID,$RoleID)){
			$data = array('msg' => '修改操作成功', 'code' => '1');
		}else{
			$data = array('msg' => '修改操作失败', 'code' => '0');
			
		}
		return $response -> withJson($data);
	}
	
	
}
?>