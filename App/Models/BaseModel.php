<?php
namespace App\Models;

class BaseModel extends SqlHelper
{
	public $_table;
	
	//连接数据库
	public function __construct()
	{
		$db = $GLOBALS['config']['db'];
		$this->connect($db['host'],$db['username'],$db['password'],$db['dbname']);
	}
	
	//	得到用户所有信息，不包括密码
	public function getMyselfInfo($email){
		$sql ="SELECT UserName,Email,Phone,Sex,Address,Age,State FROM user WHERE Email ='".$email."'";
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();
		return $sth -> fetch();
		
	}
	
//	修改个人信息
	public function setMyselfInfo($email,$name,$phone,$age,$sex,$address,$face){
		$sql = "UPDATE user SET UserName ='".$name."', Phone = '".$phone."' ,Age = ".$age." ,Sex = '".$sex."' ,Address = '".$address."', Face='".$face."' where Email='".$email."'";
		
		return $this->query($sql); 
		
	}
	
	// 查找个人信息
	public function selfSelect($email){
		$sql = "SELECT UserName,Face,role.RoleName FROM user
				LEFT JOIN usertorole
				ON `user`.ID = usertorole.UserId
				LEFT JOIN role
				ON usertorole.RoleId = role.ID
				where Email='".$email."'";
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetch();
	}
}	
?>