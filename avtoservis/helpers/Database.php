<?php
require_once 'Exceptions/exceptions.php';

class Database{
	private $_database, $_link, $_query, $_rowsNum, $_insert_id;

	public function __construct(){
		try {
			$this->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$this->_database = DB_NAME;
		} catch (ServerException $se) {
			$se->getMessage();
			$se->getExceptionMessage();
			return;
		} catch (DatabaseException $dbe){
			$dbe->getMessage();
			$dbe->getExceptionMessage();
			return;
		}

	}

	private function connect($server, $user, $password, $database){
		if(!($this->_link = mysqli_connect($server,$user,$password))){
			throw new ServerException();
		}else if(!mysqli_select_db($this->_link,$database)){
			throw new DatabaseException();
		}

	}

	public function insert($table, $data){

		$keys = array();
		$values = array();

		foreach($data as $key => $value)
		{
			$keys[] = $key;
			$values[] = "'".$value."'";
		}

		if(mysqli_query($this->_link,"INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(',', $values).")")===FALSE){
			throw new DatabaseException("Грешка при внесување на податоците!<br>".mysqli_error($this->_link));
		}
		
		$this->_insert_id = mysqli_insert_id($this->_link);
	}

	public function getInsertID()
	{
		return $this->_insert_id;
	}

	public function update($table, $data, $where){

		$query = "UPDATE ".$table." SET ";

		$totalColumns = count($data);
		$counter = 1;

		foreach($data as $key => $value){
			if($counter<$totalColumns)
				$query.=$key."="."'".$value."',";
			else
				$query.=$key."="."'".$value."'";
				
			$counter++;
		}

		$query.=" WHERE ".$where;

		if(mysqli_query($this->_link,$query)===FALSE)
			throw new DatabaseException("Грешка при ажурирање на податоците!<br>".mysqli_error($this->_link));
	}

	public function delete($table,$where){
		if(mysqli_query($this->_link,"DELETE FROM ".$table." WHERE ".$where)===FALSE)
			throw new DatabaseException("Грешка при бришење на записот!<br>".mysqli_error($this->_link));
	}

	public function get($attr="*", $table){
		if($attr=='*'){
			$this->_query = mysqli_query($this->_link,"SELECT * FROM ".$table);
		}else{
			$this->_query = mysqli_query($this->_link,"SELECT ".$attr." FROM ".$table);
		}

		$this->_rowsNum = mysqli_num_rows($this->_query);
	}

	public function getWhere($attr="*", $table, $where){
		if($attr=='*'){
			$this->_query = mysqli_query($this->_link,"SELECT * FROM ".$table." WHERE ".$where);
		}else{
			$this->_query = mysqli_query($this->_link,"SELECT ".$attr." FROM ".$table." WHERE ".$where);
		}
		
		$this->_rowsNum = mysqli_num_rows($this->_query);
	}

	public function getRowsCount(){
		return $this->_rowsNum;
	}

	public function resultFromGet($array=false)
	{

		if($this->_rowsNum==1 && $array==false)
			$result = mysqli_fetch_assoc($this->_query);
		else
		{
			$result = array();

			while($res = mysqli_fetch_assoc($this->_query))
			$result[] = $res;
		}

		return $result;
	}

	public function joinLeft($table1, $table2, $on, $where="1")
	{
		$this->_query = mysqli_query($this->_link,"SELECT $table1.*, $table2.* FROM ".$table1." LEFT JOIN ".$table2."  ON ".$on." WHERE ".$where);
		
		$this->_rowsNum = mysqli_num_rows($this->_query);
	}

	public function join($table1, $table2, $on, $where="1")
	{
		$this->_query = mysqli_query($this->_link,"SELECT $table1.*, $table2.* FROM ".$table1." JOIN ".$table2."  ON ".$on." WHERE ".$where);
		
		$this->_rowsNum = mysqli_num_rows($this->_query);
	}

	public function cleanData($data)
	{
		return mysqli_real_escape_string($this->_link,htmlentities(trim($data)));
	}

	public function closeConnection()
	{
		mysqli_close($this->_link);
	}

}
