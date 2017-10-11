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
}	
?>