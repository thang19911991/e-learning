<?php
class AdminsController extends  AppController {
	var $uses = array('User','Admin', 'Ip');
	//var $paginate;
	
	
	function beforeFilter(){		
		parent::beforeFilter();
		//$this->Auth->allow('index');
				
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
//		echo '<pre>';
//			var_dump($this->Auth->user());
//			die();
		if($this->request->is('post')){
//			
//			echo '<pre>';
//			var_dump($this->Auth->user());
//			die();
			
			$create_data = $this->request->data;
			$create_data['User']['active_status'] = 'active';
			$create_data['User']['login_status'] = 'off';
			$create_data['User']['role'] = 'admin';
			$create_data['User']['primary_password'] = AuthComponent::password($create_data['User']['password']);
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
	
	public function user_profile(){
//		echo '<pre>';
//		var_dump($this->params['named']['id']);
		$user = $this->User->find('first',array('conditions' => array('User.id' => $this->params['named']['id'])));
		if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
			$is_valid_user = false;
			$this->set('is_valid_user', $is_valid_user);
		} else {
			//session_start();
			//$_SESSION['manage_user_id'] = $user['User']['id'];
			$is_valid_user = true;
			
			$this->set('is_valid_user', $is_valid_user);
			$this->set('user', $user);	
		}
		
	}
	
	public function delete_user(){
		$this->autoRender = false;
		$this->User->deleteAll(array('User.id' => $this->params['named']['id']));
		$this->redirect(array("controller" => "admins", "action" => "student_manager"));
		
	}
	
	public function active_user(){
		$this->User->id = $this->params['named']['id'];
		$this->User->saveField('active_status', 'active');
		$this->redirect(array("controller" => "admins", "action" => "user_profile", "id" => $this->params['named']['id']));
	}
	
	public function edit_user_profile(){
		
	}
	
	
	
	
	//--------------------------------------------------------------------------------------
	
	
public function view_profile(){
		$current_user = $this->Auth->user();
				
		$ad = $this->User->find('first', array('conditions'=>array('username'=>$current_user['username'])));
		$this->set(compact("ad"));
	}
	
	public function edit_profile(){
		$username = $this->Auth->user()['username'];
//		var_dump($username);
		$ad = $this->User->find('first', array('conditions'=>array('username'=>$username)));
//		var_dump($ad);
		if(!$ad){
			throw new NotFoundException(__('Invalid Admin'));
		}
		$this->set(compact("ad"));
//		Show information on editable
//		Save button			
		if($this->request->is(array('post','put'))){
			$this->User->id = $ad['User']['id'];
			if($this->User->save($this->request->data)){
				$this->Session->setFlash(__('Your information updated successfully'));
				return $this->redirect(array('action' => 'view_profile'));
			}
			$this->Session->setFlash(__('Unable to update your information.'));
		}
		
		if(!$this->request->data){
			$this->request->data = $ad;
		}
	}
	
	function change_password() {
        
        $username = $this->Auth->user()['username'];
		$ad = $this->User->find('first', array('conditions'=>array('username'=>$username)));
		if(!$ad){
			throw new NotFoundException(__('Invalid Admin'));
		}
		$this->set(compact("ad"));
        
        if (!empty($this->request->data)) {
        	if(empty($this->request->data['password1'])){
        		$this->Session->setFlash('New password empty.');
        	}
            else if ($this->Auth->password($this->request->data['password']) == $ad['User']['password']) {
                if ($this->request->data['password1'] == $this->request->data['password2']) {
                	if($this->request->data['password1'] != $this->request->data['password']){
                		$savedata['User']['password'] = $this->data['password1'];
//						$savedata['User']['full_name'] = 'abcx';
						//echo '<pre>';
                		//var_dump($savedata);
            		    //die();
						$this->User->id = $this->Auth->user('id');
                		$this->User->save($savedata);
		                $this->Session->setFlash('Password changed.');
		                $this->redirect(array('controller'=>'admins','action' => 'view_profile'));
                	}
                	else{
                		$this->Session->setFlash('Enter difference passwords.');
                	}

                } 
                else {
                    $this->Session->setFlash('New passwords did not match.');
                }
            }
            else {
                $this->Session->setFlash('Old password fail');
            }
        }
		else {
			$this->Session->setFlash('Enter in text box.');
        }
    }
	
	
}
	
	
