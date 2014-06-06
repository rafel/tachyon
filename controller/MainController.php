<?php
/**
 * This controller routes all incoming requests to the appropriate controller
 */
include_once("controller/CoreController.php");
class MainController extends CoreController {
	function live(){
		try {
			$validationModel = $this->loadModel('model/','Validation','');
			$controller = $validationModel->isThereGet("controller","home");
			

			//compute the path to the file
			$controller = $this->loadController($controller);
			
			//pass any GET varaibles to the main method
			$controller->main();
		}
		catch(exception $e){
			//$logModel = $this->loadModel('model/', 'Log','');
			//$logModel->logExeption($e->getMessage());
			var_dump($e);
		}
	}
}
	