<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
include_once("controller/CoreController.php");
class HomeController extends CoreController {

	function main(){
		try {
			$id = $this->validation->isThereGet("id",false);
			$msg = $this->validation->isThereGet("msg",false);
			$model = $this->loadModel('model/','User','');
			$currentUser = $model->getCurrentUser();
			$this->view->appendValues(get_object_vars($currentUser));
			$this->view->loadHeader();
			$this->view->loadMenu();
			$this->view->loadMain();
			if($currentUser){
				$this->view->loadOnlineSidebar();
			}
			else {
				$this->view->loadSidebar();
			}
			$this->view->loadEnd();
			$this->view->display();
		}
		catch(exception $e){
			$logModel = $this->loadModel('model/', 'Log','');
			$logModel->logExeption($e->getMessage());			
			header("Location: ?page=Home&msg=".$e->getMessage()."");
		}
	}
}
##End Creative##
?>