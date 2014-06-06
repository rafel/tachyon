<?php
	# Name: Validation.class.php
	# File Description: Validation Class to easy clean and validate values
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-05
	# Version: 1.0
	# Copyright 2011 rafel.tk
class ValidationModel {
	
	function cleanArray($array){
		
		foreach ($array as $value) {
			$value = $this->cleanString($value);
		}
		
		return $array;
		
	}
	
	/**
	* Desc :	Checks if an email is valid
	* Param:	$email, the email should be (*@kth.se)
	* Returns:	True(if valid), False(if not valid)
	**/
	 function isEmail($email) {
		// Email is not case sensitive, making it lower case
		$email =  strtolower($email);
		
		// Only "@kth.se" emails is allowed
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@kth.se/",$email)){
			return true;
		}
		else {
			return false;
		}
	}
	/**
	* Desc : 	Checks if birthday format is correct  
	* Param: 	$birthday, the birthday should be (YYYY-MM-DD)
	* Returns:	True(the birthday), False(throws an exception)
	**/
	 function isBirthday($birthday){
		if(empty($birthday)){
			return $birthday;
		}
		
		else{
			list($y,$m,$d) = explode('-',$birthday);
			if(is_numeric($y) && is_numeric($m) && is_numeric($d)){
				if(checkdate($m,$d,$y)) {
					return $birthday;
				}
				
				else {
					throw new Exception("BIRTHDAY_INVALID");
				}
			}
			
			else{
				throw new Exception("BIRTHDAY_INVALID");
			}
		}
	}
		
	/**
	* Decs:		Checks if the string have a value otherwise return the false string
	* Param:	$current, the string to check the value of
	* Param:	$false, the string to return if false
	* Returns:	True(if the string have a value, return it), False(return the false string)
	**/
	public static function isThere($current,$false){
		if(!empty($current)){
			return($current);
		}
		else{
			return($false);
		}
	}
	
	/**
	* Decs:		Checks if two values is equal, then return true value
	* Param:	$one, the first string to match
	* Param:	$two, the second  string to match
	* Param:	$true, the true string to return
	* Returns:	True(The true string if first string match the second), False(The first string)
	**/
	public  function ifThis($one,$two,$true){
		if($one==$two){
			return($true);
		}
		else{
			return($one);		
		}
	}
	
	/**
	* Decs:		Checks if there is a POST value , otherwise return the false param
	* Param:	$current, the POST value we are looking for
	* Param:	$false, the value to return if no POST value found
	* Returns:	True(The value of found POST), False(The false value)
	**/
	public  function isTherePost($current,$false){
		if(!empty($_POST[$current])){	
			$current = $_POST[$current];
			return($current);
		}
		else{
			return($false);
		}
	}
	
	/**
	* Decs:		Checks if there is a GET value , otherwise return the false param
	* Param:	$current, the GET value we are looking for
	* Param:	$false, the value to return if no GET value found
	* Returns:	True(The value of found GET), False(The false value)
	**/
	public function isThereGet($current,$false){
		if(!empty($_GET[$current])){	
			$current = $_GET[$current];	
			return($current);
		}
		else{
			return($false);
		}
	}
	
	/**
	* Decs:		Cleans strings and protect against injections
	* Param:	$dirty, the dirty string
	* Returns:	$clean, the clean string
	**/
	public function cleanString($dirty){
		$dirty = stripslashes($dirty);
		$dirty = trim($dirty);
		$clean = mysql_escape_string($dirty);
		return $clean;
	}
	/**
	* Decs:		Checks if string is numeric , if not, removes all chars from the string, making it numeric
	* Param:	$string, the string we want to check/convert
	* Returns:	True(return the numeric string), False(Return new converted numric string)
	**/
	public function toNumeric($string){
		if(is_numeric($string)){
			return $string;
		}
		else {
			$string = preg_replace("[^A-Za-z0-9]", "",$string);
			return $string;
		}
	}
	
		/**
	* Desc :	Generate a random string
	* Param:	$length, the lenght of the random string (INT)
	* Returns:	The generated string
	**/
	public function rand_str($length){
		// Characters to generate string from
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_';
		
		// Length of character list
		$chars_length = (strlen($chars) - 1);
	
		// Start our string
		$string = $chars{rand(0, $chars_length)};
		
		// Generate random string
		for ($i = 1; $i < $length; $i = strlen($string)) {
			// Grab a random character from our list
			$r = $chars{rand(0, $chars_length)};
			
			// Make sure the same two characters don't appear next to each other
			if ($r != $string{$i - 1}) $string .=  $r;
		}		
		// Return the string
		return $string;
	}
	
	/**
	* Desc	: Checks string and logs if not valid
	* Param : $string, the string to check
	* Return: The string if clear otherwise , logs and die
	**/	
	public function checkString($string){
		if(!preg_match("/^[a-z0-9_-]+$/i",$string)) {
			$fp = fopen('../logs/hacking_log.txt', 'a');
			fwrite($fp, $_SERVER['REMOTE_ADDR']." den ".date("Y-m-d")." med {$_SERVER['REQUEST_URI']}\r\n");
			fclose($fp);
			die("404");
		}
		else{
			return($string);
		}
	}
	
}
##End Validation##
?>