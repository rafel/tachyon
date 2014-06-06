<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
include_once('db/MySQLModel.php');
class PostModel {
	protected $validation;
	
	function __construct(){
		$this->validation = new ValidationModel();
	}
		
	function run($userID){
		$cleanedArray = $this->validation->cleanArray($_REQUEST);
		if(isset($cleanedArray['action'])){
			switch ($cleanedArray['action']) {
				case 'post':
					header('Content-type: application/json');			
					$this->post($userID);
					break;
				case 'save':
					header('Content-type: application/json');
					$this->save($userID);
					break;
				case 'getPosts':
					header('Content-type: application/json');
					$this->getPosts($userID);
					break;
				case 'getTemp':
					header('Content-type: application/json');
					$this->getTemp($userID);
					break;
				case 'getComments':
					header('Content-type: application/json');
					$this->getComments($userID);
					break;
				case 'reset':
					header('Content-type: application/json');
					$this->reset($userID);
					break;
				case 'removePost':
					header('Content-type: application/json');
					$this->removePost($userID);
					break;
				case 'comment':
					header('Content-type: application/json');
					$this->comment($userID);
					break;
			}
		}
			return $false;
	}

	function getPosts($userID){
		// Register try
		try {
			$dbModel = $GLOBALS['db'];
			include($GLOBALS['DBQueries']);
			$dbModel->connect();
			//$allPossts = $dbModel->select('*','post',"");
			 $query = $selectAllPosts;
			if(isset($_GET['userid'])  && is_numeric($_GET['userid'])){
				$query = sprintf($selectAllUserPosts,$_GET['userid']);
			}

			$allPossts = $dbModel->query($query);
			$response_array = array();
			if (mysql_num_rows($allPossts)){
				// Defining user info
				while($row = mysql_fetch_assoc($allPossts)){
						$response_array[] = $row;
				}
				//$response_array = mysql_fetch_array($allPossts);
			}

			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			//$msg = 'Post shared!';
			//$response_array["msg"] = $msg;
			//$response_array["status"] = sucess;
			echo json_encode($response_array);
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

	function getComments($postID){
		// Register try
		try {
			$dbModel = $GLOBALS['db'];
			include($GLOBALS['DBQueries']);
			$dbModel->connect();
			if(!isset($_GET['postID']) && !is_numeric($_GET['postID'])){
				die();
			}
			$allPossts = $dbModel->query(sprintf($selectComments,$_GET['postID']));
			$response_array = array();
			if (mysql_num_rows($allPossts)){
				// Defining user info
				while($row = mysql_fetch_assoc($allPossts)){
						$response_array[] = $row;
				}
				//$response_array = mysql_fetch_array($allPossts);
			}

			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			//$msg = 'Post shared!';
			//$response_array["msg"] = $msg;
			//$response_array["status"] = sucess;
			echo json_encode($response_array);
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

	function getTemp($userID){
			// Register try
		try {
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$response_array = array();


			$currentTemp = $dbModel->select('*','posttemp'," WHERE userid='".$userID."'");
			if (mysql_num_rows($currentTemp)){
				// Defining user info
				while($row = mysql_fetch_array($currentTemp)){
						$temppostID = $row["postid"];
				}
				//var_dump($currentTemp);
				$currentTemp = $dbModel->select('*','post'," WHERE id='".$temppostID."'");
				while($row = mysql_fetch_array($currentTemp)){
						$currentPost = $row["content"];
				}
			}

			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			//$msg = 'Post shared!';
			$response_array["msg"] = $currentPost;
			$response_array["status"] = success;
			if($currentPost == null){
				$response_array["status"] = error;
			}
			echo json_encode($response_array);
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
	
	function post($userID){
		// Register try
		try {
			// Array with all userinfo
			$post = Array(
				'content'		=> $_POST["thepost"],
				'userid'		=> $userID
			);
			$post = $this->validation->cleanArray($post);

			// Checks if strings is empty
			if(empty($post['content']) || empty($post['userid'])){
				$msg = 'One or more fields are empty';
				throw(new Exception($msg));
				exit();
			}

			if(strlen($post["content"]) > 254){
				$$msg = 'Post max length is 255chars';
				throw(new Exception($msg));
				exit();
			}
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			$currentTemp = $dbModel->select('*','posttemp'," WHERE userid='".$userID."'");
			if (mysql_num_rows($currentTemp)){
				// Defining user info
				while($row = mysql_fetch_array($currentTemp)){
						$temppostID = $row["postid"];
				}
				$dbModel->delete("posttemp"," postid='".$temppostID."'");
				$dbModel->update("post","content", $post["content"], " id='".$temppostID."'");
			}else {
				// Commiting query
				$id = $dbModel->query_insert("post",$post);
			}



			
			$dbModel->transaction_commit();
			
			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			$msg = 'Post shared!';
			$response_array["msg"] = $msg;
			$response_array["status"] = sucess;
			echo json_encode($response_array);
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

	function comment($userID){
		// Register try
		try {
			// Array with all userinfo
			$post = Array(
				'content'		=> $_POST["thecomment"],
				'postid'		=> $_POST["postid"],
				'userid'		=> $userID
			);
			$post = $this->validation->cleanArray($post);

			// Checks if strings is empty
			if(empty($post['content']) || empty($post['userid'])){
				$msg = 'One or more fields are empty';
				throw(new Exception($msg));
				exit();
			}

			if(strlen($post["content"]) > 254){
				$msg = 'Post max length is 255chars';
				throw(new Exception($msg));
				exit();
			}
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			$id = $dbModel->query_insert("comment",$post);
			
			$dbModel->transaction_commit();
			
			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			$msg = 'Comment shared!';
			$response_array["msg"] = $msg;
			$response_array["status"] = sucess;
			echo json_encode($response_array);
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

	function save($userID){
		// Register try
		try {
			// Array with all userinfo
			$post = Array(
				'content'		=> $_POST["thepost"],
				'userid'		=> $userID
			);
			$post = $this->validation->cleanArray($post);

			// Checks if strings is empty
			if(empty($post['content']) || empty($post['userid'])){
				$msg = 'One or more fields are empty';
				throw(new Exception($msg));
				exit();
			}

			if(strlen($post["content"]) > 254 || strlen($post["content"]) < 10){
				$msg = 'Post lenth contain 10-255chars';
				throw(new Exception($msg));
				exit();
			}
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			$currentTemp = $dbModel->select('*','posttemp'," WHERE userid='".$userID."'");
			if (mysql_num_rows($currentTemp)){
				// Defining user info
				while($row = mysql_fetch_array($currentTemp)){
						$temppostID = $row["postid"];
				}
				$dbModel->update("post","content", $post["content"], " id='".$temppostID."'");
			}else {

				// Commiting query
				$id = $dbModel->query_insert("post",$post);

				$posttemp = Array(
					'postid'		=> $id,
					'userid'		=> $userID
				);
				$posttemp = $this->validation->cleanArray($posttemp);
				
				$id2 = $dbModel->query_insert("posttemp",$posttemp);
				
			}

			

			$dbModel->transaction_commit();
			
			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			$msg = 'Post saved!';
			$response_array["msg"] = $msg;
			$response_array["status"] = sucess;
			echo json_encode($response_array);
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
	function reset($userID){
		// Register try
		try {
			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			$currentTemp = $dbModel->select('*','posttemp'," WHERE userid='".$userID."'");
			if (mysql_num_rows($currentTemp)){
				// Defining user info
				while($row = mysql_fetch_array($currentTemp)){
						$temppostID = $row["postid"];
				}
				$dbModel->delete("posttemp"," postid='".$temppostID."'");
				$dbModel->delete("post"," id='".$temppostID."'");
			}

			
			$dbModel->transaction_commit();
			
			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			$msg = 'Post removed!';
			$response_array["msg"] = $msg;
			$response_array["status"] = sucess;
			echo json_encode($response_array);
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
	function removePost($userID){
		// Register try
		try {
			if(!isset($_SESSION)){
				session_start();
			}
			if(!isset($_SESSION['admin']) && $_SESSION['admin'] != true){
				$msg = 'Not admin!';
				throw(new Exception($msg));
				exit();
			}
			// Checks if strings is empty
			if(!isset($_GET['postid']) || !is_numeric($_GET['postid'])){
				$msg = 'No postid!';
				throw(new Exception($msg));
				exit();
			}


			$dbModel = $GLOBALS['db'];
			$dbModel->connect();
			$dbModel->transaction_begin();
			
			$dbModel->delete("post"," id='".$_GET['postid']."'");

			
			$dbModel->transaction_commit();
			
			// Closing connection to the database
			$dbModel->close();
			
			// Register Successful!
			$msg = 'Post removed!';
			$response_array["msg"] = $msg;
			$response_array["status"] = sucess;
			echo json_encode($response_array);
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

	
}
?>