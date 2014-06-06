<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
include_once('model/dto/Universal.php');
class ViewModel {
	protected $userModel;	
	protected $templateHeader;
	protected $templateBody;
	protected $templateFooter;
	public $data2;

	
	function __construct(){
		$this->templateHeader = new ArrayObject();	
		$this->templateBody = new ArrayObject();	
		$this->templateFooter = new ArrayObject();
		$this->data2 = new ArrayObject();
	}

	function appendValues($values){
		//var_dump($values);
		extract($values, EXTR_OVERWRITE);
		//echo $username;
		$this->data2->append($values);
		//var_dump($this->data2->getArrayCopy());
		//$this->data2->append($values);
	//	var_dump($data2);
	}



	function loadHeader() {
		$this->templateHeader->append(array("temp" => 'header', "data" => null));		   
	}
	
	function loadMenu() {
		$this->templateHeader->append(array("temp" => 'menu', "data" => null));		   
	}
	
	function loadMain() {
		$this->templateHeader->append(array("temp" => 'main', "data" => null));		   
	}
	function loadPosts() {
		$this->templateHeader->append(array("temp" => 'post', "data" => null));		   
	}
	function loadAdminPosts(){
		$this->templateHeader->append(array("temp" => "postAdmin", "data" => null));
	}
	
	function loadSideBar() {
		$this->templateHeader->append(array("temp" => 'sidebar', "data" => null));		   
	}
	function loadOnlineSideBar() {
		$this->templateHeader->append(array("temp" => 'onlinesidebar', "data" => null));		   
	}
	
	function loadEnd(){
		$this->templateFooter->append(array("temp" => 'end', "data" => null));
	}
	
	function alert($msg){
		if(strpos($msg, "ERROR_")===0||strpos($msg, "SUCCESS_")===0) {
			if(strpos($msg, "ERROR_")===0)
			{
				$messageType = "error";
				
			}
			else
			{
				$messageType = "success";
			}
			$this->templateHeader->append(array("temp" => 'alert', "data" => array("messageType" => $messageType,"message" => $message)));
		}
	}
	
	function addBody($path,$data){
		$this->templateBody->append(array("temp" => $path, "data" => $data));
	}
	
	function display(){
		foreach($this->templateHeader as $template){
			$this->load($template["temp"],$template["data"]);
		}
		foreach($this->templateBody as $template){
			$this->load($template["temp"],$template["data"]);
		}
		
		foreach($this->templateFooter as $template){
			$this->load($template["temp"],$template["data"]);
		}
	}
	
	function loadPage($path){
		$this->loadHeader();
		$this->loadMenu();
		$this->load($path);
		$this->loadEnd();
	}
	
	
	function load($path){
		$path = "view/template/".$path."Template.html";
		foreach ($this->data2 as $subarr) {
			extract($subarr, EXTR_OVERWRITE);
		}
		//var_dump($data);
		//include($path);
		$htmlString = file($path);
		foreach($htmlString as $line){
			eval("print \"" . addcslashes(preg_replace("/(---(.+?)---)/", "\\2", $line), '"') . "\";");
		}
//		ob_start();

		//echo "".$username;
		//include $path;
		//$htmlString = ob_get_clean();
		//eval($htmlString);
		//$filtered = $this->searchAndReplace($htmlString,$data);
	}
} 
?>