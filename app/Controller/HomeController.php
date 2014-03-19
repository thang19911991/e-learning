<?php
class HomeController extends AppController{
	public $layout = 'home_page';
	
	public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
	function index(){
		
	}
}