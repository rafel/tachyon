<?php
	# Name: Core.class.php
	# File Description: Creative Class is a mixed class with different useful functions and mostly useful only for this website
	# Author: Rafel Ridha
	# Web: http://www.rafel.se
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2014 rafel.se

include_once('model/ViewModel.php');
include_once('model/ConfigListModel.php');
include_once('model/ValidationModel.php');
include_once('model/db/MySQLModel.php');

class CoreController {
	
	protected $view;
	protected $links;
	protected $lang;
	protected $validation;
	protected $user;
	protected $db;
	
	function __construct(){
		$this->view = new ViewModel();
		$this->links = new ConfigListModel();
		$this->validation = new ValidationModel();
		$this->db = new MySQLModel();
		$GLOBALS['db'] = $this->db;
		$GLOBALS['DBQueries'] = 'db/DBQueries.php';
	}
	
	
	function loadController($controller){
		if(isset($this->links->location["controller"][$controller])){
			$location=$this->links->location["controller"][$controller];
		}
		else{
			$location = $this->links->location["controller"]["Home"];
		}
		include_once "controller/".$location.".php";
		$controller = new $location;
		
		return $controller;
	}
	
	function loadPage(){
		$pageModel = $this->loadModel('Page');
		$pageModel->display();
	}
	
	function loadLang(){
		$langModel = $this->loadModel('Lang');
		$langModel->loadLang();
	}
	
	function loadModel($folder,$model,$after){
		$model = $model."Model";
		include_once($folder.$model.".php".$after);
		$model = new $model;
		return $model;
	}
	
	function main(){
		$mainModel = $this->loadModel('Main');
		$this->view->load('Main',$mainData);
	}

}
##End CoreController##
?>