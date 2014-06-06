<?php
	# Name: MySQL.class.php
	# File Description: MySQL Class is class used to allow easy communcation with the database
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
include_once('conf/db.conf.php');
include_once('model/dto/Universal.php');
class MySQLModel {
	
	protected $link;
	####
	#
	# Desc: Constructor
	#
	####
	function MySQLModel($server = DB_SERVER, $user = DB_USER, $database= DB_DATABASE, $pass = DB_PASS, $pre=''){
		$this->server=$server;
		$this->user=$user;
		$this->pass=$pass;
		$this->database=$database;
		$this->pre=$pre;
	}
	
	
	#! Connects and select database using vars from constructor! #
	function connect($new_link=false) {
		$this->link_id=@mysql_connect($this->server,$this->user,$this->pass,$new_link);
	
		if (!$this->link_id) {
			throw new Exception("MYSQL_CONNECT_FAIL");
		}
	
		if(!@mysql_select_db($this->database, $this->link_id)) {
			throw new Exception("MYSQL_CONNECT_FAIL");
		}
	
		// unset the data so it can't be dumped
		$this->server='';
		$this->user='';
		$this->pass='';
		$this->database='';
	}
	
	function getLink(){
		return $this->link_id;
	}
	
	
	#! Close connection to Database !#
	function close() {
		if(!@mysql_close($this->link_id)){
			throw new Exception("MYSQL_CLOSE_FAIL");
		}
	}
	
	/**
	* Desc  : Escapes characters to precent SQL injections
	* Param : The string to escapes
	* Return: The cleaned string
	**/	
	function escape($string) {
		if(get_magic_quotes_runtime()){			
			$string = stripslashes($string);
		}
		return mysql_real_escape_string($string);
	}
	
	/**
	* Desc	: Execute the SQL query
	* Param : SQL query to execute
	* Return: Result from Database
	**/
	function query($sql) {

		$this->query_id = @mysql_query($sql, $this->link_id);
		
		if (!$this->query_id) {
			throw new Exception($sql);
		}
		
		$this->affected_rows = @mysql_affected_rows($this->link_id);
	
		return $this->query_id;
	}	
	
	/**
	* Desc  : Executing an insert query from an array
	* Param : $table, the table to insert the values to
	* Param : $data, the array with the data
	* Return: Result from the Database
	**/
	function query_insert($table, $data) {
		$q="INSERT INTO `".$this->pre.$table."` ";
		$v=''; $n='';
	
		foreach($data as $key=>$val) {
			$n.="`$key`, ";
			if(strtolower($val)=='null') $v.="NULL, ";
			elseif(strtolower($val)=='now()') $v.="NOW(), ";
			else $v.= "'".$this->escape($val)."', ";
		}
	
		$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";
	
		if($this->query($q)){
			return mysql_insert_id($this->link_id);
		}
		else {
			throw new Exception("MYSQL_FAIL");
		}
	
	}
	
	/**
	* Desc  : Executing an insert query from an array
	* Param : $table, the table to insert the values to
	* Param : $data, the array with the data
	* Return: Result from the Database
	**/
	function select($select, $table, $where) {

		$select = $this->escape($select);
		$table = $this->escape($table);
		$where = $where;
		$q= "SELECT ".$select." FROM ".$table.$where;

		$result = $this->query($q);

		if($result){

			return $result;
		}
		else {

			throw new Exception("MYSQL_SELECT_FAIL");
		}
	
	}


	/**
	* Desc  : Executing an insert query from an array
	* Param : $table, the table to insert the values to
	* Param : $data, the array with the data
	* Return: Result from the Database
	**/
	function update($table, $what, $with, $where) {

		$select = $this->escape($select);
		$what = $this->escape($what);
		$with = $this->escape($with);
		$where = $where;
		$q= "UPDATE ".$table." SET ". $what."='".$with . "' WHERE ".$where;

		$result = $this->query($q);

		if($result){

			return $result;
		}
		else {

			throw new Exception("MYSQL_SELECT_FAIL");
		}
	
	}


	/**
	* Desc  : Executing an insert query from an array
	* Param : $table, the table to insert the values to
	* Param : $data, the array with the data
	* Return: Result from the Database
	**/
	function delete($table, $where) {

		$table = $this->escape($table);
		$where = $where;
		$q= "DELETE FROM ".$table." WHERE ".$where;

		$result = $this->query($q);

		if($result){

			return $result;
		}
		else {

			throw new Exception("MYSQL_SELECT_FAIL");
		}
	
	}




	#! Starts a MySQL transaction !#
	function transaction_begin(){
		@mysql_query("BEGIN",$this->link_id);
	}
	
	#! Commits a MySQL transaction !#
	function transaction_commit(){
		$result = @mysql_query("COMMIT",$this->link_id);
		if($result){
			return true;
		}
		else {
			transaction_rollback();
			throw new Exception("MYSQL_FAIL");
		}
	}
	
	#! Rollbacks a MySQL transaction !#
	function transaction_rollback(){
		if(isset($this->link_id)){
			if($this->link_id){
				@mysql_query("ROLLBACK",$this->link_id);
				$this->close();				
			}
		}
	}


	function getUserByID($userid){

		//$result = mysql_query($query,this->link_id);
		$result = $this->select(
				" user.id,user.email,user.created,user.username, profile.* ",
				" user LEFT JOIN profile ON user.id = profile.userid",
				" WHERE user.id='".$userid."'"
			);

		if (mysql_num_rows($result)){
			$user = array();
			$count = 0;
			$returnarray = array();
			$user = mysql_fetch_array($result);
			foreach ($user as $key => $value){
				if(!is_numeric($key)){
					if($key == "photo"){
						if($value=="" || $value=="null" || empty($value)){
							$value = "photo.gif";
						}
					}
					$returnarray[$key] = $value;
					$count++;
				}
			}
			return arrayToObject($returnarray);
		}else {
			return false;
		}
	}

	function getPosts(){

		//$result = mysql_query($query,this->link_id);
		$result = $this->select(
				" user.id,user.email,user.created,user.username, profile.* ",
				" user LEFT JOIN profile ON user.id = profile.userid",
				" WHERE user.id='".$userid."'"
			);

		if (mysql_num_rows($result)){
			$user = array();
			$count = 0;
			$returnarray = array();
			$user = mysql_fetch_array($result);
			foreach ($user as $key => $value){
				if(!is_numeric($key)){
					$returnarray[$key] = $value;
					$count++;
				}
			}
			return arrayToObject($returnarray);
		}else {
			return false;
		}
	}
		
}
##End MySQL##
?>