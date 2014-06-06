<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
class UserController extends CoreController {

	function main(){
		try {
			$model = $this->loadModel('model/','User','');
			$model->run();
			if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
				$currentUser = $model->getUserByID($_GET['userid']);
			}else {
				$currentUser = $model->getCurrentUser();
			}
			if(!$currentUser){
				header("location: ?controller=home");
			}
			//var_dump($currentUser);
			$this->view->appendValues(get_object_vars($currentUser));
			$this->view->loadHeader();
			$this->view->loadMenu();
			$this->view->loadOnlineSidebar();
			if($model->isAdmin()){
				$this->view->loadAdminPosts();
			}else {
				$this->view->loadPosts();
			}
			$this->view->loadEnd();
			$this->view->display();

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