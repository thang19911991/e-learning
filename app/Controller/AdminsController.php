<?php
class AdminsController extends  AppController {

	function beforeFilter(){
		
		parent::beforeFilter();
		$this->Auth->allow('index');
				
	}
	
	public function index(){
		
	}
}