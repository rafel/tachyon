<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
include_once('ValidationModel.php');
include_once('db/MySQLModel.php');
class UserModel {
	protected $validation;
	
	function __construct(){
		$this->validation = new ValidationModel();
	}
		
	function run(){
		$cleanedArray = $this->validation->cleanArray($_REQUEST);
		if(isset($cleanedArray['action'])){
			switch ($cleanedArray['action']) {
				case 'login':		
					header('Content-type: application/json');			
					$this->login();
					break;
				case 'userRole':		
					header('Content-type: application/json');			
					$this->getUserRole();
					break;
				case 'register':
					header('Content-type: application/json');
					$this->register();
					break;
				case 'editProfile':
					$this->editProfile();
					break;
				case 'logout':
					$this->logOut();
					break;
			}
		}
			return $false;
	}

	#! Desc : Logout, destroy sessions !#
	public function logOut(){
		// Starting sessions
		session_start();
		
		// Emptying sessions
		$_SESSION['userID'] = '';
		$_SESSION['logged_in'] = false;
		
		// Destroying sessions
		session_destroy();
		header("Location: ?controller=home");
		exit();
	}
	
	function register(){
		// Register try
		try {
			// Array with all userinfo
			$user = Array(
				'email'			=> $_POST["email"],
				'username'		=> $_POST["username"],
				'password'		=> $_POST["password"]
			);
			$user = $this->validation->cleanArray($user);

			// Checks if strings is empty
			if(empty($user['username']) || empty($user['email']) || empty($user['password'])){
				$msg = 'One or more fields are empty';
				throw(new Exception($msg));
				exit();
			}
			
			// Checks if email is valid
			if(!$this->validation->isEmail($user['email'])){
				$msg = 'Invalid email, only @kth.se allowed';
				throw(new Exception($msg));
				exit();
			}
			
			// Checks if firstname or lastname is more than 35chars
			if(strlen($user['username']) < 2 || strlen($user['username']) > 10){
				$msg = 'Username must be longer than 2 characters and less than 10';
				throw(new Exception($msg));
				exit();
			}
			
			$user['password'] = $this->generateHash($user['password']);

			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			
			if(mysql_fetch_array($dbModel->select('email','user'," WHERE email='".$user['email']."'")) > 0){
				$msg = 'This email is already in use';
				throw(new Exception($msg));
				exit();
			}
			else if(mysql_fetch_array($dbModel->select('username','user'," WHERE username='".$user['username']."'")) > 0){
				$msg = 'Username already in use';
				throw(new Exception($msg));
				exit();
			}
			else {
				// Commiting query
				$id = $dbModel->query_insert("user",$user);
				$profile = Array('userid' => $id,'photo' => "photo.gif");
				$dbModel->query_insert("profile",$profile);
				
				$dbModel->transaction_commit();
				
				// Closing connection to the database
				$dbModel->close();
				
				// Register Successful!
				$msg = 'Registration successful, please login in';
				$response_array["msg"] = $msg;
				$response_array["status"] = sucess;
				echo json_encode($response_array);
				exit();
			}

		}
		// Catches errors if any
		catch(Exception $e){
			// Register Failed!
			//$dbModel->transaction_rollback();
			//echo($e->getMessage());
			$response_array["msg"] = $e->getMessage();
			$response_array["status"] = error;
			echo json_encode($response_array);
			exit();
		}
	}


	function editProfile(){
		// Register try
		try {
			// Array with all userinfo
			$user = Array(
				'name'		=> $_POST["name"],
				'title'		=> $_POST["title"]
			);
			$user = $this->validation->cleanArray($user);

			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			
			
			// Commiting query
			$id = $dbModel->update("profile","name", $user["name"],  " userid='".$this->getUserID()."'");
			$id = $dbModel->update("profile","title",$user["title"], " userid='".$this->getUserID()."'");
			$dbModel->transaction_commit();
			
			// Closing connection to the database
			$dbModel->close();
			echo "";
			header("Location: " . $_SERVER['HTTP_REFERER']);
			exit();

		}
		// Catches errors if any
		catch(Exception $e){
			// Register Failed!
			//$dbModel->transaction_rollback();
			//echo($e->getMessage());
			$response_array["msg"] = $e->getMessage();
			$response_array["status"] = error;
			echo json_encode($response_array);
			exit();
		}
	}	

	#! Checks if password match !#
	public function matchPassword($userPassword, $saltAndHash)	{
		$hashValues = preg_split('/\./', $saltAndHash);
		$salt = $hashValues[0];
		$hash = $hashValues[1];
		$salt2 = $hashValues[2];
		if((hash("sha512", md5($salt.$userPassword.$salt2))) == $hash){
			return true;
		}
		else{
			return false;
		}
	}
	
	#! Takes a password then generates a salt and creates a hash. Returns salt+hash #!
	public function generateHash($userPassword) {
		$salt = $this->generateSalt();
		$salt2 = $this->generateSalt();
		$result = $salt.".".hash("sha512", md5($salt.$userPassword.$salt2)).".".$salt2;
	
		return $result;
	}
	
	#! Generate 10 character salt !#
	private function generateSalt() {
		$possibleValues = '0123456789abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ';
		$salt = '';		
		for($i = 0; $i < 10; $i++) {
			$salt .= $possibleValues[mt_rand(0, strlen($possibleValues)-1)];	
		}		
		return $salt;
	}
	public function getUser(){
		$query = "SELECT user.id,user.email,user.created,user.username, profile.* FROM user LEFT JOIN profile ON user.id = profile.userid";
	}

	public function login(){
		// Register try
		try {

			// Checks if strings is empty
			if(!(isset($_POST["username"]) && strlen($_POST['username']) > 0 && isset($_POST['password']) && strlen($_POST['password']) > 0)){
				$msg = 'Enter your username and password';
				throw(new Exception($msg));
				exit();
			}
			// Array with all userinfo
			$user = Array(
				'username'		=> $_POST["username"],
				'password'		=> $_POST["password"]
			);			

			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			
			$user = $this->validation->cleanArray($user);	
			
			// Tru login user
			$id = $this->verifyLogin($user['username'],$user['password']);
			if($id){
				$dbModel->close();
				header("Location: ?page=Home");
				$msg = "Logging in...";
				$response_array["msg"] = $msg;
				$response_array["status"] = sucess;
				echo json_encode($response_array);
				exit();
			}
			else {
				sleep(2);
				$dbModel->close();
				$msg = 'Wrong password or username, please try again';
				$response_array["msg"] = $msg;
				$response_array["status"] = error;
				echo json_encode($response_array);
				exit();
			}
		}
		// Catches errors if any
		catch(Exception $error){
			// Register Failed!
			$response_array["msg"] = $error->getMessage();
			$response_array["status"] = error;
			echo json_encode($response_array);
			exit();
		}
	}

	/* Validate a member login from data in a MySQL Database. */
	public function verifyLogin($username, $password) {

		if(empty($username) || empty($password)) {
			throw new Exception("One or more fields are empty");
		}	
		else {
			$dbModel = $GLOBALS['db'];
			$result = $dbModel->select('*','user'," WHERE username='".$username."'");
			
			if($row = mysql_fetch_array($result)){
				if ($password == $this->matchPassword($password, $row['password'])) {
					$admin = false;
					$adminresult = $dbModel->select('*','admin'," WHERE userid='".$row['id']."'");
					if(mysql_num_rows($adminresult)){
						$admin = true;
					}
					$this->setSessions($row['id'],$admin);	
					return $row['id'];					
				}
				else {
					throw new Exception("Wrong password or username, please try again");
				}
			}
		}	
		mysql_free_result($result);			
	}

	#! Start sessions if login succeed!#
	public function setSessions($id,$admin) {	
		session_start();
		
		$_SESSION['userID'] = $id;
		$_SESSION['logged_in'] = true;
		if($admin == true){
			$_SESSION['admin'] = true;
		}
	}

	#! Checks if user is inlogged !#
	public function isLoggedIn(){
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_SESSION['logged_in']) && isset($_SESSION['userID']) && $_SESSION['logged_in'] == true){
			return true;
		}
		else {
			return false;
		}
	}

	public function getUserRole(){
		if($this->isAdmin()){
			$response_array["userrole"] = admin;
			$response_array["id"] = $this->getUserID();
		}
		else if($this->isLoggedIn()){
			$response_array["userrole"] = user;
			$response_array["id"] = $this->getUserID();
		}
		else {
			$response_array["userrole"] = offline;
			$response_array["id"] = null;
		}
		echo json_encode($response_array);
		exit();
	}

	#! Checks if user is admin !#
	public function isAdmin(){
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
			return true;

		}
		else {
			return false;
		}
	}

	public function getUserID(){

		if(!isset($_SESSION)){
			session_start();
		}
		if($this->isLoggedIn()){
				return $_SESSION['userID'];			
		}
		return false;
	}

	public function getCurrentUser(){
		if($this->isLoggedIn()){
			$currentUserID = $this->getUserID();
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$currentUser = $dbModel->getUserByID($currentUserID);
			//var_dump($currentUser);
			//exit();
			$dbModel->close();
			return $currentUser;
		}
		return false;
	}

	public function getUserById($id){
		if($this->isLoggedIn()){
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$currentUser = $dbModel->getUserByID($id);
			//var_dump($currentUser);
			//exit();
			$dbModel->close();
			return $currentUser;
		}
		return false;
	}
}
?>