<?php
App::import('Model','Teacher');
class TeacherController extends AppController{
	public $components = array('Session');
	
	public function beforeFilter(){
		parent::beforeFilter();
		//$this->Auth->allow("register");
	}
	
	public function test(){
		echo time();
	}
	
	public function confirm_verify_code($teacher_id){
		if($this->Session->check('TempLock')){
			$this->Teacher->unbindModel(array('hasMany' => array('Course')));
			$teacher = $this->Teacher->find('first', array(
					'conditions' => array(
					'Teacher.id' => $teacher_id
				)
			));
		
			$this->set(compact("teacher"));
		
			if($this->request->is('post')){
				$data = $this->request->data;
				$this->Teacher->set($data);
				
				if($this->Teacher->validates()){
					$teacher = $this->Teacher->find('first', array(
						'fields' => array('Teacher.*'),
						'conditions' => array(
							'Teacher.verify_code_answer' => $data['Teacher']['verify_code_answer'],
							'Teacher.verify_code' => $data['Teacher']['verify_code']
						)
					));
					if(!empty($teacher)){
						echo "thanh cong";
					}else{
						echo "khong thanh cong";
					}
				}
			}
		}
	}
	
	public function index(){
		$this->loadModel("User");
		$users = $this->User->find(
			'all',array('fields' => array('User.id','User.username','User.full_name', 'User.birthday', 'User.address', 'User.role')
			)
		);
		$this->set(compact("users"));
	}
	
	// Su dung cho autocomplete de suggest tag
	public function key(){		
	    $this->autoRender = false;
	    $this->loadModel("Tag");
	    
	    $keyword = $this->params['url']['term'];
	    
	    $codes = $this->Tag->find('all', array('conditions' => array('tag_name LIKE' => "%".$keyword."%")));	    
	    return new CakeResponse(array('body' => json_encode($codes)));
	}

	public function show_courses(){
		$this->set('title_for_layout', 'コースリストを表す');
		$this->loadModel('Course');
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller' => 'teacher', 'action' => 'login'));
		}
		
		$teacher_id = $this->Auth->user('Teacher');
		$teacher_id = $teacher_id['id'];
				
		if($teacher_id){						
			$courses = $this->Course->find('all',array('conditions' => array('Course.teacher_id' => $teacher_id)));
			
			$this->set(compact("courses"));
			$this->set("teacher_id",$this->Auth->user('id'));
			$this->set("teacher_name",$this->Auth->user('username'));
		}else{
			$this->Session->setFlash("username khong ton tai");
		}
	}
	
	public function edit_course($id = null){
		$this->set('title_for_layout', 'コース編集');
		$this->loadModel('Course');
		$this->loadModel('CourseTag');				
		
		$this->set("id", $id);
		
		$this->Course->recursive = 2;
		$courses = $this->Course->find('all',array(
			'conditions' => array(
				'Course.id' => $id
			)
		));
		
		if(!$courses){
			$this->Session->setFlash("id khong ton tai");
			return $this->redirect(array('action' => 'view_course'));
		}
				
		$this->set(compact("courses"));
		
		if($this->request->is('Post')){
			$data = $this->request->data;
			
			var_dump($data);
			
			/*
			unset($data['tag']);
			$this->Course->id = $id;
			if($this->Course->save($data)){
				$this->Session->setFlash("Update thanh cong");				
			}else{
				$this->Session->setFlash("Update khong thanh cong");
			}
			return $this->redirect(array('controller' => 'teacher', 'action' => 'view_course'));
			*/
		}
	}
	
	public function delete_course($id = null){
		$this->loadModel('Course');
		$this->Course->delete($id, true);
		return $this->redirect(array('controller' => 'teacher', 'action' => 'show_courses'));
	}
	
	public function view_a_course($id = null){
		$this->set('title_for_layout', 'コースを見る');
		$this->loadModel('Course');
		$this->loadModel('CourseTag');				
		
		$this->Course->recursive = 2;
		$courses = $this->Course->find('all',array(
			'conditions' => array(
				'Course.id' => $id
			)
		));
		
		if(!$courses){
			$this->Session->setFlash("id khong ton tai");
			return $this->redirect(array('action' => 'view_course'));
		}
		
		$this->set("id", $id);
		$this->set(compact("courses"));
		
		if($this->request->is('Post')){
			$data = $this->request->data;
			unset($data['tag']);
			$this->Course->id = $id;
			if($this->Course->save($data)){
				$this->Session->setFlash("Update thanh cong");				
			}else{
				$this->Session->setFlash("Update khong thanh cong");
			}
			return $this->redirect(array('controller' => 'teacher', 'action' => 'view_course'));
		}
	}
	
	public function register(){
		$this->set('title_for_layout', '先生の登録');
		$this->loadModel('User');
		$this->loadModel('Teacher');
		
		$validator = $this->User->validator();
		unset($validator['credit_number']['format_of_student']);
		
		if($this->request->is('post')){
			// khi set mảng $data vào trong model User để có thể thực hiện được validate
			$this->User->set($this->request->data);
			
			if($this->User->validates()){
				// This method resets the model state for saving new information
				$this->User->create();
				
				// dữ liệu gửi từ Form lên
				$data  = $this->request->data;
				
				// mã hóa password theo định dạng : username + password + t01
				$data['User']['password'] = AuthComponent::password($data['User']['username']."+".$data['User']['password']."+t01");				
				
				if(!empty($data['User']['profile_img'])){
					$tmp_name_file_image = $data['User']['profile_img']['tmp_name'];
					$filename = $data['User']['username']."-".$this->data['User']['profile_img']['name'];
				}
				
				// xoá phần từ repassword đi khỏi mảng để insert không bị lỗi
				unset($data['User']['re_password']);
				unset($data['User']['checkbox']);
				
				// convert định dạng của birthday
				$birthday = $data['User']['birthday'];
				unset($data['User']['birthday']);
				$data['User']['birthday'] = $birthday['year']."-".$birthday['month']."-".$birthday['day'];
				
				$data["User"]["role"] = 'teacher';
				$data["User"]["active_status"] = User::INACTIVE;
				$data["User"]["login_status"] = User::OFF_LOGIN_STATUS;
				$data["User"]["primary_password"] = $data["User"]["password"];
				$data["User"]["last_action_time"] = date('Y-m-d H:i:s');
										
				if($filename!=""){
					$data['User']['profile_img'] = "/img/Avatar/". $filename;
					
					$path = WWW_ROOT.'img'.DS.'Avatar'.DS.$filename;
					if(!move_uploaded_file($tmp_name_file_image, $path)){
						$this->Session->setFlash("ファイルをアップロードできない");
						return FALSE;
					}
				}
				
				// luu du lieu trong Form register vao trong bang User
				$user = $this->User->save($data);
				if(!empty($user)){
					// The ID of the newly created user has been set as $this->User->id.
					$this->request->data['Teacher']['user_id'] = $this->User->id;
					
					// add them 1 so thong tin vao trong mang Teacher trong data array
					$this->request->data['Teacher']['verify_code'] = $this->request->data['User']['verify_code'];
					$this->request->data['Teacher']['verify_code_answer'] = $this->request->data['User']['verify_code_answer'];
					$this->request->data['Teacher']['primary_verify_code_answer'] = $this->request->data['User']['verify_code_answer'];
					$this->request->data['Teacher']['additional_info'] = $this->request->data['User']['information'];
					$this->request->data['Teacher']['additional_info'] = $this->request->data['User']['information'];
					$this->request->data['Teacher']['last_session_ip'] = $this->request->clientIp();					
					
					$this->User->Teacher->save($this->request->data);
					$this->Session->setFlash(__("Register successful"));
					$this->redirect(array('controller' => 'teacher', 'action' => 'login'));
				}else{
					$this->Session->setFlash(__("Unable to register"));
				}
			}
		}
	}
	
	public function login(){
		$this->loadModel('User');
		$this->set('title_for_layout', 'ログイン');
		if(!$this->Session->check("fail_login_count")){
			echo "Session : chua khoi tao";
		}else{
			echo "Session : ".$this->Session->read("fail_login_count");
		}
		
		// kiem tra xem Session đã tồn tại hay chua, nếu chưa thi redirect den index
		if($this->Auth->logIn()){
			return $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
		}
		
		// Nếu mà chưa login thì cần login và lưu Session
		if ($this->request->is('post')) {
			$data = $this->request->data;
	        if($data){	        	
	        	$data['User']['password'] = AuthComponent::password($data['User']['username']."+".$data['User']['password']."+t01");
	        		        	
	        	// thực hiện kiểm tra username và password(đã mã hóa) trong CSDL, nếu mà ok thì
	        	// sẽ tự động lưu thông tin của user vào trong Session
	        	// hàm này mặc định là sẽ tìm trong bảng Users với 2 trường username, password
	        	// do đó mà ta cần phải cấu hình lại cái $components, cấu hình được đặt trong AppController
	        	
	        	$teacher = $this->User->find('first', array(
	        		'conditions' => array(
	        			'username' => $data['User']['username'],
	        			'password' => $data['User']['password'],
	        		)
	        	));
	        	
		        if (!empty($teacher)) {
		        	$this->Auth->login($teacher['User']);
		        	$this->Session->write("fail_login_count","login thanh cong");
	                $this->Session->setFlash("Login thanh cong");
	               	return $this->redirect(array('controller' => 'home', 'action' => 'index'));
	            }else{
	            	$this->Session->write("fail_login_count","login khong thanh cong");
	            	$this->Session->setFlash(__('Invalid username or password'));
	            }
	        }
        }
	}
	
	public function logout(){
		// tự động chuyển đến URL mà đã đăng kí trong AppController.php
		// tự động xóa Session đi (trong $this->Auth->logout() đã có xóa Session)
		$this->Session->destroy();
		return $this->redirect($this->Auth->logout());
	}
}
?>
