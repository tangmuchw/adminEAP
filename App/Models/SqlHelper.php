<?php
	namespace App\Models;
	use PDO;
/**
 * SqlHelper.class.php 是框架的核心部分。为什么？
 * 因为通过它，我们创建了一个 SQL 抽象层，可以大大减少了数据库的编程工作。
 * 虽然 PDO 接口本来已经很简洁，但是抽象之后框架的可灵活性更高。
 * 这里的数据库句柄$this->_dbHandle还能用单例模式返回，让数据读写更高效，这部分可自行实现。
 */
class SqlHelper {
	protected $_dbHandle;
	protected $_result;
	protected $filter = '';

	// 连接数据库
	public function connect($host, $username, $password, $dbname) {
		try {
			$dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $dbname);
			$option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
			$this -> _dbHandle = new PDO($dsn, $username, $password, $option);
		} catch (PDOException $e) {
			exit('错误: ' . $e -> getMessage());
		}
	}

	// 查询条件
	public function where($where = array()) {
		if (isset($where)) {
			$this -> filter .= ' WHERE ';
			$this -> filter .= implode(' ', $where);
		}

		return $this;
	}

	// 排序条件
	public function order($order = array()) {
		if (isset($order)) {
			$this -> filter .= ' ORDER BY ';
			$this -> filter .= implode(',', $order);
		}

		return $this;
	}

	// 查询所有
	public function selectAll() {
		$sql = sprintf("select * from `%s` %s", $this -> _table, $this -> filter);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetchAll();
	}

	// 根据条件 (id) 查询
	public function select($id) {
		$sql = sprintf("select * from `%s` where `id` = '%s'", $this -> _table, $id);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> fetch();
	}
//public function selectmsg($name,$pas) {
//		$sql = sprintf("select * from `%s` where `Email` = '%s','Password'='%s'", $this -> _table, $name,$pas);
//		$sth = $this -> _dbHandle -> prepare($sql);
//		$sth -> execute();
//
//		return $sth -> fetch();
//	}
	// 根据条件 (id) 删除
	public function delete($id) {
		$sql = sprintf("delete from `%s` where `id` = '%s'", $this -> _table, $id);
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> rowCount();
	}

	// 自定义SQL查询，返回影响的行数
	public function query($sql) {
		$sth = $this -> _dbHandle -> prepare($sql);
		$sth -> execute();

		return $sth -> rowCount();
	}

	// 新增数据
	public function add($data) {
		$sql = sprintf("insert into `%s` %s", $this -> _table, $this -> formatInsert($data));

		return $this -> query($sql);
	}

	// 修改数据
	public function update($id, $data) {
		$sql = sprintf("update `%s` set %s where `id` = '%s'", $this -> _table, $this -> formatUpdate($data), $id);

		return $this -> query($sql);
	}

	// 将数组转换成插入格式的sql语句
	private function formatInsert($data) {
		$fields = array();
		$values = array();
		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s`", $key);
			$values[] = sprintf("'%s'", $value);
		}

		$field = implode(',', $fields);
		$value = implode(',', $values);

		return sprintf("(%s) values (%s)", $field, $value);
	}

	// 将数组转换成更新格式的sql语句
	private function formatUpdate($data) {
		$fields = array();
		foreach ($data as $key => $value) {
			$fields[] = sprintf("`%s` = '%s'", $key, $value);
		}

		return implode(',', $fields);
	}

}
?>