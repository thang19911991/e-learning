<?php
class AdminsController extends  AppController {
	var $uses = array('User','Admin', 'Ip', 'Course','Teacher','Document');
	//var $paginate;
	public $layout = 'admin';
	
	function beforeFilter(){		
		parent::beforeFilter();
		//$this->Auth->allow('index');
		if($this->Auth->user('role') != 'admin') {
			$this->redirect(array('controller' => 'users', 'action' => 'restrict_area'));
		}
				
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
		if(isset($this->params['named']['id'])){
			$user = $this->User->find('first',array('conditions' => array('User.id' => $this->params['named']['id'])));
			if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
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
		if(isset($this->params['named']['id'])){
			$this->User->id = $this->params['named']['id'];
			$this->User->saveField('active_status', 'active');
			$this->redirect(array("controller" => "admins", "action" => "user_profile", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "student_manager"));
		}
		
	}
	
	public function edit_user_profile(){
		if(isset($this->params['named']['id'])){
		$user = $this->User->find('first',array('conditions' => array('User.id' => $this->params['named']['id'])));
			if(!isset($user['User']) || ($user['User']['role'] == 'admin')){
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
//			$course = $this->Course->find('all'
//			,array('conditions' => array('Course.id' => 2))
//			);
//			
//			$result['Course']['teacher_id']
//			echo '<pre>';
//			var_dump($result);
//			die();
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
		if(isset($this->params['named']['id'])){
			$this->Course->id = $this->params['named']['id'];
			$this->Course->saveField('status', 'active');
			$this->redirect(array("controller" => "admins", "action" => "course_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	public function deactive_course(){
		if(isset($this->params['named']['id'])){
			$this->Course->id = $this->params['named']['id'];
			$this->Course->saveField('status', 'inactive');
			$this->redirect(array("controller" => "admins", "action" => "course_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	public function course_detail(){
		
		
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
		if(isset($this->params['named']['id'])){
			
			$doc = $this->Document->find('first',array('conditions' => array('Document.id' => $this->params['named']['id'])));
			$teacher  = $this->Teacher->find('first',array('conditions' => array('Teacher.id' => $doc['Course']['teacher_id'])));
			
			$user = $this->User->find('first', array('conditions' => array('User.id' => $teacher['Teacher']['user_id'])));
			
			$doc['User'] = $user['User'];
			//debug($doc);die();
			$this->set(compact('doc'));
			

		} else {
			$this->redirect(array("controller" => "admins", "action" => "index"));
		}
	}
	
	public function delete_document(){
		$this->autoRender = false;
		if(isset($this->params['named']['id'])){
			
			if($this->Document->deleteAll(array('Document.id' => $this->params['named']['id']))){
				$this->Session->setFlash('Document has been deleted');
			} else {
				$this->Session->setFlash('Deleting document did not success, please try a gain');
			}
			
		
		}
		$this->redirect(array("controller" => "admins", "action" => "course_manager"));
	}
	
	public function active_document(){
		if(isset($this->params['named']['id'])){
			$this->Document->id = $this->params['named']['id'];
			$this->Document->saveField('status', 'active');
			$this->redirect(array("controller" => "admins", "action" => "document_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	public function deactive_document(){
		if(isset($this->params['named']['id'])){
			$this->Document->id = $this->params['named']['id'];
			$this->Document->saveField('status', 'deactive');
			$this->redirect(array("controller" => "admins", "action" => "document_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	
	
	
	
	//--------------------------------------------------------------------------------------
	
	
	public function view_profile(){
		$current_user = $this->Auth->user();
				
		$ad = $this->User->find('first', array('conditions'=>array('username'=>$current_user['username'])));
		$this->set(compact("ad"));
	}
	
	public function edit_profile(){
		$username = $this->Auth->user('username');
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
        
        $username = $this->Auth->user('username');
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
	
//    Input is admin's user ID
	public function change_ip($user_admin_id = null){
		$current_user_admin_id = $this->Auth->user('id');
		$current_admin_login_ip = $this->request->clientIp();
		
		$user_admin = $this->User->findById($user_admin_id);
//		debug($user_admin);
		
		if($user_admin == null || $user_admin['User']['role'] != 'admin' || ($current_user_admin_id != $user_admin_id && $user_admin['User']['login_status'] == 'on')){
			throw new NotFoundException("Invalid admin ID or this admin is login");
		}
		
		$option = false;
		if($current_user_admin_id == $user_admin_id) $option = true;
		
		$this->set('option', $option);
		$this->set('current_admin_login_ip', $current_admin_login_ip);
		$this->set('admin', $user_admin);
		
		if($this->request->is(array('post','put'))){
			$request_data = $this->request->data;
//			debug($current_admin_login_ip);
//			debug($request_data['Ip']['IP']);
			if ($option == true){
				if(strpos($request_data['Ip']['IP'], $current_admin_login_ip) === false) $validate_ip_list = false;
				else $validate_ip_list = $this->_check_ip_list($request_data['Ip']['IP']);
			}
			else $validate_ip_list = $this->_check_ip_list($request_data['Ip']['IP']);
			
			if($validate_ip_list == true){
				if($this->Ip->save($this->request->data)){
					$this->Session->setFlash(__('Update IP list successfully'));
					if($option == true){
						$this->redirect(array('action' => 'view_profile'));
					} else{
						$this->redirect(array('action' => 'admin_manage'));
					}
				} else{
					$this->Session->setFlash(__('Unable to update IP list.'));
				}
			}
			else{
				$this->Session->setFlash(__('IP list is incorrect or current login IP not in IP list.'));
			}
		}
		
	}
	
	protected function _check_ip_list($ip_list = null){
		$ips = preg_split('/[;]+/', $ip_list);
		if (count($ips) == 0) return false;
		foreach ($ips as $ip){
			if ($ip == null) return false;
			$ip = str_replace(" ", "", $ip);
			if ($this->_validate_ip($ip) == false) return false;
		}
//		Check IP repeat
		for($i = 0; $i < count($ips); $i ++){
			for($j = $i+1; $j < count($ips); $j ++){
				echo $i . ':' . $j . '<br>';
				if($this->_compare_ip($ips[$i], $ips[$j]) == true) return false;
			}
		}
		return true;
	}
	
	protected function _compare_ip($ip1 = null, $ip2 = null){
		echo $ip1 . ': ' . $ip2;
//		Replace space
		$tmp_ip1 = str_replace(" ", "", $ip1);
		$tmp_ip2 = str_replace(" ", "", $ip2);
		if(strcmp($tmp_ip1, $tmp_ip2)) return false;
		else return true;
	}
	protected function _validate_ip($ip = null){
		$tmp_ip = str_replace(" ", "", $ip);
//		echo $tmp_ip.'<br>';
		if(filter_var($tmp_ip, FILTER_VALIDATE_IP)) return true;
		else return false;
	}
}
	
	
