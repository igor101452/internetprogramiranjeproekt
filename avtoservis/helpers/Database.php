<?php
require_once 'Exceptions/exceptions.php';

class Database{
	private $_database, $_link, $_query, $_rowsNum;

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
			throw new DatabaseException("Greska pri vnesuvanje na podatocite!<br>".mysqli_error($this->_link));
		}
		

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
			throw new DatabaseException("Greska pri azuriranje na podatocite!<br>".mysqli_error($this->_link));
	}

	public function delete($table,$where){
		if(mysqli_query($this->_link,"DELETE FROM ".$table." WHERE ".$where)===FALSE)
			throw new DatabaseException("Greska pri brisenje na zapisot!<br>".mysqli_error($this->_link));
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

	public function resultFromGet()
	{
		$result = array();

		while($res = mysqli_fetch_assoc($this->_link,$this->_query))
			$result[] = $res;

		return $result;
	}

	public function cleanData($data)
	{
		return mysqli_real_escape_string($this->_link,htmlentities(trim($data)));
	}

}
