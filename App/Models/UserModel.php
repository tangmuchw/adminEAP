<?php
namespace App\Models;

class UserModel extends BaseModel
{
	public function __construct()
	{
		parent::__construct();
		$this -> _table = 'user';
	}
	
	//	得到用户邮箱和密码信息
	public function getUserInfo($username,$password){
		
		$sql = sprintf("select * from `%s` where `Email` = '%s' and `UserPwd` = '%s'", $this -> _table, $username, $password);
		return $this -> query($sql);
		
	}
	
	//	得到用户所有信息
	public function getUserFullInfo(){
		$sql = sprintf("select ID,UserName,Email,Phone,Sex,Address,Age,State from `%s`", $this -> _table);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();
		return $sth -> fetchAll();
		
	}
	
	//得到用户所对应的访问权限并判断是否具有该权限
	public function getUserRoleToPower($user,$urlpath){
		$sql = "SELECT power.ControllerAction FROM `user` INNER JOIN usertorole
		on user.ID = usertorole.UserId
		INNER JOIN role
		on  usertorole.RoleId = role.ID
		INNER JOIN roletopower
		on role.ID = roletopower.RoleId
		INNER JOIN power
		on roletopower.PowerId = Power.ID
		left JOIN menu
		on Power.ActionId = power.ID 
		where UserName='".$user."' and power.ControllerAction='".$urlpath."'";
		
		return $this->query($sql); 
	}
	
	public function getUserToRole($email){
		$sql = "SELECT roleId FROM `user` INNER JOIN usertorole
			on user.ID = usertorole.UserId
			where Email='".$email."'";
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetch();
	}
	
//	新增用户
	public function addNewUser($username,$password,$email){
		$sql ="INSERT INTO ".$this->_table." (ID,UserName,UserPwd,Email,Phone,Sex,Address,Age,State) VALUES (null,'".$username."','".$password."','".$email."',null,null,null,null,null)";
//		$sql = sprintf("INSERT INTO `%s` (ID,UserName,UserPwd,Email,Phone,Sex,Address,Age,State) VALUES (null,'%s','%s','%s',null,null,null,null,null)",$this->_table,$username,$password,$email);
//		var_dump($sql);
//		$sql ="INSERT INTO user (ID,UserName,UserPwd,Email,Phone,Sex,Address,Age,State) VALUES (null,'xioa','sss','sss',null,null,null,null,null)";
		return $this->query($sql); 
	}
	
	//删除用户
	public function deleteUSer($email){
		$sql = "UPDATE ".$this->_table." SET State ='无效' where Email='".$email."'";
		return $this->query($sql); 
	}
	
//	搜索用户
	public function selectUser($username){
		$sql = sprintf("select ID,UserName,Email,Phone,Sex,Address,Age,State from `%s` where `UserName` = '%s'", $this -> _table, $username);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetchAll();
	}
	//编辑用户
	public function updateUser($email,$state){
		$sql = "UPDATE ".$this->_table." SET State ='".$state."' where Email='".$email."'";
		return $this->query($sql); 
	}
	
}
?>