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
}	
?>