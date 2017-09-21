<?php
namespace App\Models;

class RoleModel extends UserModel
{
	public function __construct()
	{
		parent::__construct();
		$this -> _table = 'role';
	}

	//	得到角色所有信息
	public function getRoleFullInfo(){
		$sql = sprintf("select * from `%s`", $this -> _table);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();
		return $sth -> fetchAll();
		
	}

	//新增角色
	public function addNewRole($id,$rolename){
		$sql ="INSERT INTO ".$this->_table." (ID,RoleName) VALUES ($id,'".$rolename."')";
//		$sql = sprintf("INSERT INTO `%s` (ID,UserName,UserPwd,Email,Phone,Sex,Address,Age,State) VALUES (null,'%s','%s','%s',null,null,null,null,null)",$this->_table,$username,$password,$email);
//		var_dump($sql);
//		$sql ="INSERT INTO user (ID,UserName,UserPwd,Email,Phone,Sex,Address,Age,State) VALUES (null,'xioa','sss','sss',null,null,null,null,null)";
		return $this->query($sql); 
	}

	//删除用户
	public function deleteRole($id){
		$sql = "DELETE FROM ".$this->_table." where ID = ".$id;
		return $this->query($sql); 
	}
	
	//	搜索角色
	public function selectUser($rolename){
		$sql = sprintf("select * from `%s` where RoleName = '%s'", $this -> _table, $rolename);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetchAll();
	}

		//编辑角色
		public function updateRole($roleID,$rolename){
			$sql = "UPDATE ".$this->_table." SET RoleName ='".$rolename."' where ID=".$roleID;
			return $this->query($sql); 
		}

	//编辑角色
	public function selectUserToRole($roleID){
				$sql = "SELECT `user`.ID,`user`.UserName FROM ".$this->_table." INNER JOIN usertorole 
				ON role.ID = usertorole.RoleId
				INNER JOIN user 
				ON usertorole.UserId = `user`.ID where role.ID =".$roleID;
				$sth = $this -> _dbHandle -> prepare($sql);
				$sth -> execute();
		
				return $sth -> fetchAll();
	}
	
	//	搜索用户对应的角色
	public function selectRoleOfUser($username){
		
		$sql = "select user.ID,UserName,RoleName from `user`
				left JOIN usertorole
				ON user.ID = usertorole.UserId
				left JOIN role
				on usertorole.RoleId = role.ID
				where UserName ='".$username."'";
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetchAll();
	}
	
	//删除用户对应的角色
	public function deleteRoleOfUser($id){
		$sql = "DELETE FROM usertorole where UserId= ".$id;
		return $this->query($sql); 
	}
	
	//新增用户对应的角色
	public function addRoleOfUser($userId,$roleId){
//		判断用户是否有角色
		$sql1 = "select usertorole.RoleId from user 
			LEFT JOIN usertorole
			ON `user`.ID = usertorole.UserId
			where user.ID = ".$userId;
		$sth = $this -> _dbHandle -> prepare($sql1);
		$sth -> execute();

		$ret =	$sth->fetch();
//		var_dump($ret);
		if($ret['RoleId'] == null){
			$sql ="INSERT INTO usertorole (RoleId,UserId) VALUES (".$roleId.",".$userId.")";
			
		}else{
			$sql ="UPDATE usertorole SET RoleId =".$roleId." where UserId =".$userId;
			
		}

		return $this->query($sql); 
	}
	
}
?>