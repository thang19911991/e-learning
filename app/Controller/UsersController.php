<?php
App::import('Model','User');
App::import('Model','Teacher');
App::import('Controller', 'Teachers');
class UsersController extends AppController{
	public function beforeFilter(){
		parent::beforeFilter();
		//$this->Auth->allow("register");
	}
	
	function index(){
		echo "day la trang index";
		var_dump($this->Session->read("User"));
	}
	
	public function login(){
		$params = $this->getSystemParams();
		
		if($params!=FALSE){
			// kiem tra xem co thoi gian lock hay khong
			if($this->Session->check(parent::TempLock_time)){
				$locked_time = $params[SystemParam::TEMP_LOCK_TIME] - (time()-$this->readSessionLockTime());
				if($locked_time>0){
					$this->renderLockTime($locked_time);
				}else{
					// xoa Session Wrong Password
					$this->deleteSessionWrongPasswordTime();
					// sau khi mà user đã bị lock 60s thì lúc này sẽ yêu cầu nhập câu hỏi bí mật
					// nếu như user này đã tồn tại trong hệ thống, nếu ko tồn tại thì sẽ login lại
					$this->processActiveStatus();
				}
			}
			
			// kiem tra post form
			if($this->request->is('post')){
				$username = $this->request->data['User']['username'];
				$password = $this->request->data['User']['password'];
				$password = AuthComponent::password($username."+".$password."+t01");
				$user = $this->User->find('all', array(
					'conditions' => array(
						'username' => $username,
						'password' => $password
					)
				));
				
				// khi đăng nhập thành công
				if(!empty($user)){
					// xóa SESSION WRONG PASSWORD
					$this->deleteSessionWrongPasswordTime();
					
					// chưa xóa Session locktime được vì còn kiểm tra xem
					// user là teacher hay student để còn yêu cầu verify_code
					$user = $user[0];					
					
					// cần kiểm tra xem user này đã actived hay chưa
					switch($user['User']['active_status']){
						case User::ACTIVED:
							$this->Session->write("User.username",$user['User']['username']);
							$this->Session->write("User.id",$user['User']['id']);
							$this->Session->write("User.role",$user['User']['role']);
										
							// cần kiểm tra xem user là loại nào
							if($user['User']['role']==User::TEACHER){
								// lúc này sẽ kiểm tra xem user này có bị khóa hay không
								if($user['User']['login_status']==User::LOCK_LOGIN_STATUS){ // tài khoản bị khóa
									// vì nó đã bị khóa rôi nên phải yêu cầu nhập câu hỏi bí mật
									$this->redirect(array('controller' => 'teachers', 'action' => 'confirm_verify_code', $user['Teacher']['id']));
								}else{
									// kiểm tra xem địa chỉ IP có trùng với địa chỉ ban đầu hay không								
									if($user['Teacher']['last_session_ip']==$this->request->clientIp()){
										unset($user['Student']);
										$this->Auth->login($user);
										$this->redirect(array('controller' => 'teachers', 'action' => 'index'));
									}else{
										$this->Session->setFlash('前回とは違う別のIPアドレスです。Verifycodeを入力してください');
										$this->redirect(array('controller' => 'teachers', 'action' => 'confirm_verify_code', $user['Teacher']['id']));
									}
								}
							}else if($user['User']['role'] == User::STUDENT){
								//TODO lúc này sẽ redirect đến trang home
								unset($user['Teacher']);
								$this->Auth->login($user);
								$this->redirect(array('controller' => 'student', 'action' => 'std_index'));
							}
							break;
						case User::INACTIVE:
							$this->renderUserInactive();
							break;
						case User::BANNED:
							$this->renderUserBaned();
							break;
					}
				}else{
					if($this->Session->check(parent::Login_wrong)){
						$wrong_password_time = $this->readSessionWrongPasswordTime();
						if($wrong_password_time<4){
							// lưu tên username vào trong Session USER_TEMP_NAME
							$this->Session->write(parent::USER_TEMP_NAME, $this->request->data['User']['username']);
							
							$this->writeSessionWrongPasswordTime($wrong_password_time+1);
							$wrong_password_time = $this->readSessionWrongPasswordTime();
							echo "wrong pass time : ". ($wrong_password_time);
						}else{
							$this->writeSessionLockTime(time());
							$this->deleteSessionWrongPasswordTime();
							$this->renderLockTime($params[SystemParam::TEMP_LOCK_TIME]);
						}
					}else{
						echo "wrong pass time : 1";
						$this->writeSessionWrongPasswordTime(1);
					}
				}
			}
		}
	}
	
	// thay đổi login_status thành on
	function changeLoginStatusToOn($teacher){
		$this->User->id = $teacher['User']['id'];
		$this->User->saveField('login_status', User::ON_LOGIN_STATUS);
	}
	
	// thay đổi login_status thành lock
	function changeLoginStatusToLOCK($teacher){
		$this->User->id = $teacher['User']['id'];
		$this->User->saveField('login_status', User::LOCK_LOGIN_STATUS);
	}
	
	// kiểm tra trạng thái active_status của người dùng
	protected function processActiveStatus(){
		$username = $this->Session->read(parent::USER_TEMP_NAME);
		$user = $this->User->find('first', array(
			'conditions' => array(
				'username' => $username
			)
		));
		
		if(!empty($user)){ // nếu username đó tồn tại thì cần xem active_status
			switch($user['User']['active_status']){
				case User::BANNED:
					// TODO cần báo cáo đến người dùng biết là tài khoan đang bị ban
					echo "dang bi baned";
					$this->redirect(array('controller' => 'home', 'action' => 'index'));
					$this->logout();
					break;
				case User::INACTIVE:
					//TODO cần báo cáo đến người dùng biết là tài khoan chưa active
					echo "dang bi inactive";
					$this->logout();
					$this->redirect(array('controller' => 'home', 'action' => 'index'));
					break;
				case User::ACTIVED:
					//TODO cần yêu cầu câu hỏi bí mật để có thể login vào được
					echo "da actived";
					$this->processRequireVerifycode($user);
					break;
			}
		}else{ // nếu mà username đó không tồn tại trong CSSL thì cần login lại
			$this->deleteSessionLockTime();
			$this->deleteSessionWrongPasswordTime();
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}
	
	protected function processRequireVerifycode($user){
		switch($user['User']['role']){
			case User::TEACHER:
				$teacherController = new TeachersController;
				$this->redirect(array('controller' => 'teachers', 'action' => 'confirm_verify_code',$user['Teacher']['id']));
				break;
			case User::STUDENT:
				//TODO cần yêu cầu login lại do học sinh không yêu cầu câu hỏi bí mật
				$this->logout();
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
				break;
		}
	}
	
	protected function processRequireVerifycodeWithoutPassword($user){
		switch($user['User']['role']){
			case User::TEACHER:				
				//TODO xác nhận câu hỏi bảo mật
				
				break;
			case User::STUDENT:
				// cần yêu cầu login lại do học sinh không yêu cầu câu hỏi bí mật
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
				break;
		}
	}
	
	// render đến trang mà người dùng chưa active tài khoản
	protected function renderUserInactive(){
		//$this->logout();
		$this->render("/Users/user_inactive");
	}
	
	// render đến trang mà tài khoản bị ban
	protected function renderUserBaned(){
		//$this->logout();
		$this->render("/Users/user_inactive");
	}
	
	// reder đến trang lock tài khoản tạm thời
	protected function renderLockTime($lock_time){
		$this->set("temp_lock_time", $lock_time);
		$this->render('/Users/temp_lock_user');
	}
	
	// logout tài khoản
	function logout(){
		$this->Session->delete('User');
		$this->Session->delete(parent::TempLock);
		$this->Session->delete(parent::TempLock_time);
		$this->Session->delete(parent::Login);
		$this->Session->delete(parent::USER_TEMP_NAME);
		return $this->redirect(array('controller'=>'users', 'action'=>'login'));
	}
	
	protected function readSessionLockTime(){
		return $this->Session->read(parent::TempLock_time);
	}
		
	protected function writeSessionLockTime($lock_time){
		$this->Session->write(parent::TempLock_time, $lock_time);
	}
	
	protected function deleteSessionLockTime(){
		$this->Session->delete(parent::TempLock);
	}
	
	protected function readSessionWrongPasswordTime(){
		return $this->Session->read(parent::Login_wrong);
	}
	
	protected function writeSessionWrongPasswordTime($wrong_time){
		$this->Session->write(parent::Login_wrong, $wrong_time);
	}
	
	protected function deleteSessionWrongPasswordTime(){
		$this->Session->delete(parent::Login);
	}
}