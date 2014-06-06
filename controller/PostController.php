<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
class PostController extends CoreController {

	function main(){
		try {
			$userModel = $this->loadModel('model/','User','');
			$model = $this->loadModel('model/','Post','');
			$userID = $userModel->getUserID();
			//if($userID){
				$model->run($userID);
			//}
		}
		catch(exception $e){
			$logModel = $this->loadModel('model/', 'Log','');
			$logModel->logExeption($e->getMessage());
			header("Location: ?page=User&action=".$model->getPath()."&msg=".$e->getMessage()."");
			exit();
		}
	}

}
##End Creative##
?>