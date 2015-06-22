<?php
//DB.class.php

class DB {

	protected $db_name = 'a_database';
	protected $db_user = 'root';
	protected $db_pass = '';
	protected $db_host = 'localhost';

	//open a connection to the database. Make sure this is called
	//on every page that needs to use the database.
	public function connect() {
		try{
			$connection = @mysql_connect($this->db_host, $this->db_user, $this->db_pass);
			mysql_select_db($this->db_name);
			return true;
		}catch(Exception $e){
			echo 'Could not connect to database';
			return false;
		}
	}

	//takes a mysql row set and returns an associative array, where the keys
	//in the array are the column names in the row set. If singleRow is set to
	//true, then it will return a single row instead of an array of rows.
	public function processRowSet($rowSet, $singleRow=false)
	{
		$resultArray = array();
		while($row = mysql_fetch_assoc($rowSet))
		{
			array_push($resultArray, $row);
		}

		if($singleRow === true)
			return $resultArray[0];

		return $resultArray;
	}

	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	/*public function select($table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1)
			return $this>processRowSet($result, true);

		return $this>processRowSet($result);
	}*/
	
	//Incorporated selection of specific columns.
	//Requires column array as input
	//Not tested, should work
	
	public function select($table, $where,$column_array='*') {
		
		if($column_array!='*'){
			$columns='';
			foreach($column_array as $current_column){
				$columns .= ($columns == "") ? "" : ", ";
				$columns .= $current_column;
			}
		}else
			$columns='*';
		$sql = "SELECT $columns FROM $table WHERE $where";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1){
			return $this->processRowSet($result, true);
		}else if(mysql_num_rows($result) == 0){
			return NULL;
		}
		return $this->processRowSet($result);
	}
	

	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function update($data, $table, $where) {
		foreach ($data as $column => $value) {
			$sql = "UPDATE $table SET $column = $value WHERE $where";
			mysql_query($sql) or die(mysql_error());
		}
		return true;
	}
	//Should delete rows. Unsure how to test this. Should be ok. Lite only.
	public function delete($table,$where){
		$sql="DELETE FROM $table WHERE $where";
		if(mysql_query($sql))
			return true;
		else
			return false;
	}
	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insert($data, $table) {

		$columns = "";
		$values = "";

		foreach ($data as $column => $value) {
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}

		$sql = "insert into $table ($columns) values ($values)";

		mysql_query($sql) or die(mysql_error());

		//return the ID of the user in the database.
		return mysql_insert_id();

	}
	
	
	

}

?>