<?php
class AdminsController extends  AppController {
	var $uses = array('User','Admin', 'Ip');
	//var $paginate;
	
	
	function beforeFilter(){		
		parent::beforeFilter();
		$this->Auth->allow('index');
				
	}
	
	public function index(){
		
	}
	
	public function student_manager() {
		$this->paginate  = array(
		'limit' => 5,
		'order' => array('User.username' => 'asc'),
		'conditions' => array('role' => 'student')
		); 
		$users = $this->paginate('User');
		$this->set("users",$users);
	}
	
	public function teacher_manager() {
			$this->paginate  = array(
			'limit' => 5,
			'order' => array('User.username' => 'asc'),
			'conditions' => array('role' => 'teacher')
			); 
			$users = $this->paginate('User');
			$this->set("users",$users);
		}
		
	public function create_admin() {
		if($this->request->is('post')){
			
//			echo '<pre>';
//			var_dump($this->request->data);
//			die();
			
			$create_data = $this->request->data;
			$create_data['User']['role'] = 'admin';
			$this->User->create();
			//unset($this->User->validate['user_id']);
			$this->User->saveAll($create_data);
//			$user = array();
//			$user = $create_data;
//			$user['role'] = 'admin';
//			$user['active_status'] = '1';
//			$this->User->create();
//			$this->User->save($user);
//			$user['id'] = $this->User->getInsertID();
			
			//$admin = array();
			
//			echo '<pre>';
//			var_dump($create_data);
//			die();
//			
//			$user['User']['username'] = $create_data['Admin']['username'];
//			$user['User']['password'] = $create_data['Admin']['password'];
			
			
			
			
		}
	}
}
	
	
