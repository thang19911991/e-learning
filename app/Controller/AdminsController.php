<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
#require_once '/home/phihung/WorkSpace/e-learning/app/Vendor/SimpleExcel/SimpleExcel.php';

class AdminsController extends  AppController {
	var $uses = array('User','Admin', 'Ip', 'Course','Teacher','Document','SystemParam');
	//var $paginate;
	public $layout = 'admin';
	
	function beforeFilter(){
		parent::beforeFilter();

		//$this->Auth->allow('index');
				

	}
	
	public function index(){
		$user = $this->User->find('all');
		$online_user = $this->User->find('all', array('conditions' => array('User.login_status' => 'on')));
		//debug(sizeof($user));die();
		$inactive_user = $this->User->find('all', array('conditions' => array('User.active_status' => 'inactive')));
		$course = $this->Course->find('all');
		$inactive_course = $this->Course->find('all', array('conditions' => array('Course.status' => 'inactive')));
		$document = $this->Document->find('all');
		$this->set(compact('user'));
		$this->set(compact('online_user'));
		$this->set(compact('inactive_user'));
		$this->set(compact('course'));
		$this->set(compact('inactive_course'));
		$this->set(compact('document'));
	}
	
	public function student_manager() {
		$this->writeLog(array(
            'id' => 'AD_LOG_01_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View list students user',
            'content' => 'Admin: '.$this->Auth->user('id').' View list students user',
            'type' => 'operation'
        ));
        

		$this->paginate  = array(
		'limit' => 5,
		'order' => array('User.username' => 'asc'),
		'conditions' => array('role' => 'student')
		); 
		$users = $this->paginate('User');
		$this->set("users",$users);
	}
	
	public function teacher_manager() {

		$this->writeLog(array(
            'id' => 'AD_LOG_02_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View list teachers user',
            'content' => 'Admin: '.$this->Auth->user('id').' View list teachers user',
            'type' => 'operation'
        ));
        
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
			$create_data['Admin']['verify_code_id'] = '345';
			$this->User->saveAll($create_data);
		}
	}
	
	public function user_profile(){
		$this->writeLog(array(
            'id' => 'AD_LOG_04_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View profile of an user',
            'content' => 'Admin: '.$this->Auth->user('id').' view an user profile',
            'type' => 'operation'
        ));
		if(isset($this->params['named']['id'])){
			$user = $this->User->find('first',array('conditions' => array('User.id' => $this->params['named']['id'])));
//	if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
			if(false){
				$is_valid_user = false;
				$this->set('is_valid_user', $is_valid_user);
			} else {
				//session_start();
				//$_SESSION['manage_user_id'] = $user['User']['id'];
				$is_valid_user = true;
				if($user['User']['role'] == 'teacher'){
					$teacher = $this->Teacher->find('first',array('conditions' => array('Teacher.user_id' => $this->params['named']['id'])));
					$this->set('teacher', $teacher);	
				}
				
				$this->set('is_valid_user', $is_valid_user);
				$this->set('user', $user);	
			}
		} else {
			$this->redirect(array("controller" => "admins", "action" => "student_manager"));
		}
		
	}
	
	public function delete_user(){
		$this->autoRender = false;
		$this->writeLog(array(
            'id' => 'AD_LOG_05_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Delete an user',
            'content' => 'Admin: '.$this->Auth->user('id').' delete an user has id: '.$this->params['named']['id'],
            'type' => 'operation'
        ));
		if(isset($this->params['named']['id'])){
			
		$user = $this->User->findById($this->params['named']['id']);
		if($user){
			if($user['User']['login_status'] != 'on'){
				
				if($this->User->deleteAll(array('User.id' => $this->params['named']['id']))){
					$this->Session->setFlash('User has been deleted');
				} else {
					$this->Session->setFlash('Deleting user did not success, please try a gain');
				}
				
			} else {
				$this->Session->setFlash('Cannot delete user is logging in, please try again later');
				$this->redirect(array("controller" => "admins", "action" => "user_profile", "id" => $this->params['named']['id']));
			}	
		} 
			
		
		}
		$this->redirect(array("controller" => "admins", "action" => "student_manager"));
		
	}
	
	public function active_user(){
		$this->writeLog(array(
            'id' => 'AD_LOG_06_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Active an user',
            'content' => 'Admin: '.$this->Auth->user('id').' active an user has id: '.$this->params['named']['id'],
            'type' => 'operation'
        ));
		
		if(isset($this->params['named']['id'])){
			$this->User->id = $this->params['named']['id'];
			$this->User->saveField('active_status', 'active');
			$this->redirect(array("controller" => "admins", "action" => "user_profile", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "student_manager"));
		}
		
	}
	
	public function edit_user_profile(){
		$this->writeLog(array(
            'id' => 'AD_LOG_07_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Edit an user information',
            'content' => 'Admin: '.$this->Auth->user('id').' edit an user has id: '.$this->params['named']['id'],
            'type' => 'operation'
        ));
		
		if(isset($this->params['named']['id'])){
		$user = $this->User->find('first',array('conditions' => array('User.id' => $this->params['named']['id'])));
//			if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
			if(false){
				$is_valid_user = false;
				$this->set('is_valid_user', $is_valid_user);
			} else {
				//session_start();
				//$_SESSION['manage_user_id'] = $user['User']['id'];
				$is_valid_user = true;
				
				$this->set('is_valid_user', $is_valid_user);
				$this->set(compact('user'));	
			}
		}
		 
		elseif ($this->data) {
				//var_dump($this->data);
				$this->User->id = $this->data['User']['id'];
				
				if($this->User->save($this->request->data)){
					$this->Session->setFlash(__('Information updated successfully'));
					return $this->redirect(array('action' => 'user_profile', 'id' => $this->data['User']['id']));
				} else {
					 $tmp = $this->User->find('first',array('conditions' => array('User.id' => $this->data['User']['id'])));
					 $user = $this->data;
					 $user['User']['username'] = $tmp['User']['username'];
					 $is_valid_user = true;
					 $this->set('is_valid_user', $is_valid_user);
					 $this->set(compact('user'));	
					 $this->Session->setFlash(__('Unable to update information.'));
				}
									
				//$this->redirect(array("controller" => "admins", "action" => "user_profile", "id" => $this->data['User']['id']));
				
		} else {
			
				return $this->redirect(array('action' => 'index'));
		}
		
		
	}
	
	public function course_manager(){
		$this->writeLog(array(
            'id' => 'AD_LOG_08_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View list course',
            'content' => 'Admin: '.$this->Auth->user('id').'View courses list' ,
            'type' => 'operation'
        ));
        
		$this->paginate  = array(
		'limit' => 5,
		//'order' => array('User.username' => 'asc')
		//'conditions' => array('role' => 'student')
		); 
		$courses = $this->paginate('Course');
		
		foreach($courses as  $key => $course) {
			$user = $this->User->find('first',array('conditions'=> array('User.id' => $course['Teacher']['user_id'])));
			$courses[$key]['Teacher']['name'] = $user['User']['username'];
			$courses[$key]['Teacher']['user_id'] = $user['User']['id'];
		}
		//debug($courses);
		$this->set("courses",$courses);
	}
	
	
	public function is_valid_user($user_id){
		
		
		$this->autoRender = false;
		$user = $this->User->find('first',array('conditions' => array('User.id' => $user_id)));
		
		if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
				return false;
			} else {
				return true;	
			}
	}
	
	public function delete_course(){
		$this->writeLog(array(
            'id' => 'AD_LOG_09_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Delete a course',
            'content' => 'Admin: '.$this->Auth->user('id').'Delete a course has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
        
		$this->autoRender = false;
		if(isset($this->params['named']['id'])){
			
			if($this->Course->deleteAll(array('Course.id' => $this->params['named']['id']))){
				$this->Session->setFlash('Course has been deleted');	
			} else {
				$this->Session->setFlash('Deleting course did not success, please try again');
			}
		
		}
		$this->redirect(array("controller" => "admins", "action" => "course_manager"));
	}
	
	public function active_course(){
		$this->writeLog(array(
            'id' => 'AD_LOG_10_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Active a course',
            'content' => 'Admin: '.$this->Auth->user('id').'Active a course has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
		
		if(isset($this->params['named']['id'])){
			$this->Course->id = $this->params['named']['id'];
			$this->Course->saveField('status', 'active');
			$this->redirect(array("controller" => "admins", "action" => "course_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	public function kanrisha_manager(){
		$this->writeLog(array(
            'id' => 'AD_LOG_40_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View list admin users',
            'content' => 'Admin: '.$this->Auth->user('id').'View list admin users' ,
            'type' => 'operation'
        ));
		
		$this->paginate  = array(
		'limit' => 5,
		'order' => array('User.username' => 'asc'),
		'conditions' => array('role' => 'admin')
		); 
		$users = $this->paginate('User');
		$this->set("users",$users);
	}
	
	public function deactive_course(){
		$this->writeLog(array(
            'id' => 'AD_LOG_11_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Deactive a course',
            'content' => 'Admin: '.$this->Auth->user('id').'Deactive a course has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
		
		
		if(isset($this->params['named']['id'])){
			$this->Course->id = $this->params['named']['id'];
			$this->Course->saveField('status', 'inactive');
			$this->redirect(array("controller" => "admins", "action" => "course_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	public function course_detail(){
		$this->writeLog(array(
            'id' => 'AD_LOG_12_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View detail of a course',
            'content' => 'Admin: '.$this->Auth->user('id').'View detail of course has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
		
		
		if(isset($this->params['named']['id'])){
			
			$course = $this->Course->find('first',array('conditions' => array('Course.id' => $this->params['named']['id'])));
			$user = $this->User->find('first', array('conditions' => array('User.id' => $course['Teacher']['user_id'])));
			$course['User'] = $user['User'];
			$this->set(compact('course'));
			
			
			
//			
//			$course = $this->Course->find('first',array('conditions' => array('Course.id' => $this->params['named']['id'])));
//			if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
//				Hello, Admin thinh$is_valid_user = false;
//				$this->set('is_valid_user', $is_valid_user);
//			} else {
//				//session_start();
//				//$_SESSION['manage_user_id'] = $user['User']['id'];
//				$is_valid_user = true;
//				
//				$this->set('is_valid_user', $is_valid_user);
//				$this->set('user', $user);	
//			}
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
		
	
	}
	
	public function document_detail(){
		$this->writeLog(array(
            'id' => 'AD_LOG_13_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View detail of a document',
            'content' => 'Admin: '.$this->Auth->user('id').'View detail of document has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
		
		if(isset($this->params['named']['id'])){
			
			$doc = $this->Document->find('first',array('conditions' => array('Document.id' => $this->params['named']['id'])));
			$teacher  = $this->Teacher->find('first',array('conditions' => array('Teacher.id' => $doc['Course']['teacher_id'])));
			
			$user = $this->User->find('first', array('conditions' => array('User.id' => $teacher['Teacher']['user_id'])));
			
			$doc['User'] = $user['User'];
			//debug($doc);die();
			$this->set(compact('doc'));
			

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






?>

	
	
