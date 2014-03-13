<?php

App::import('Model','User');
App::import('Model','Teacher');
App::import('Controller', 'Teachers');
class UsersController extends AppController{

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('logout', 'login', 'index','confirm_verify_code');
	}

	function index(){

	}

	function admin_login(){
		if($this->request->is('post')){
			$data = $this->request->data;
			$this->User->set($data);
			
			$validator = $this->User->validator();
			unset($validator['username']['unique']);
			unset($validator['username']['min_length']);
			unset($validator['username']['max_length']);
			
			if($this->User->validates()){
				$data['User']['password'] = AuthComponent::password($data['User']['username']."+".$data['User']['password']."+t01");
				$user = $this->User->find('first', array(
					'conditions' => array(
						'User.username' => $data['User']['username'],
						'User.password' => $data['User']['password']
					)
				));


		
		if($this->request->is('post')) {
			if($this->Auth->login()){
				$user = $this->Auth->user();
//				echo '<pre>';
//				var_dump($user);
//				die();
				if($user['role'] == 'admin') {
					if($user['Ip']['IP'] == $this->request->clientIp()){
						$this->User->id = $user['id'];
            			$this->User->saveField('login_status','on');
						$this->Session->setFlash(__('You logged in successfully'));
						$this->redirect('/admins');

					} else {
						$this->Auth->logout();
						$this->Session->setFlash(__('Invalid username or password'));
					}
				} else {
					$this->Session->setFlash(__('Invalid username or password'));
				}
			}
		} else {
			$user = $this->Auth->user();


			if($user['role'] == 'admin') {
				$this->redirect('/admins');
			} else {
				$this->Auth->logout();

			}
		}
	}

	// ユーザのログイン
	public function login(){
	
		

		if ($this->request->is('post')) {
            if ($this->Auth->login()) {
            	$user = $this->Auth->user();
            	$this->User->id = $user['id'];
            	$this->User->saveField('login_status','off');
            	
            	// Sau khi login thì lưu Session
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')));
                $this->redirectUser($user);
                
               
            }   else {
            $this->Session->setFlash(__('Invalid username or password'));	
            }          
                        
        }

	}

	// ONにlogin_statusを変化する
	function changeLoginStatusToOn($teacher){
		$this->User->id = $teacher['User']['id'];
		$this->User->saveField('login_status', User::ON_LOGIN_STATUS);
	}

	// LOCKにlogin_statusを変化する
	function changeLoginStatusToLOCK($teacher){
		$this->User->id = $teacher['User']['id'];
		$this->User->saveField('login_status', User::LOCK_LOGIN_STATUS);
	}

	// ユーザのactive_statusをチェック
	protected function processActiveStatus(){
		$username = $this->Session->read(parent::USER_TEMP_NAME);
		$user = $this->User->find('first', array(
			'conditions' => array(
				'username' => $username
		)
		));

		if(!empty($user)){ // ユーザが既存の場合、active_statusをチェックしなきゃ
			switch($user['User']['active_status']){
				case User::BANNED:
					// TODO ユーザに「アカウントの状態が禁止している」メッセージを表す
					$this->Session->setFlash("ユーザのアカウントが禁止している");
					$this->redirect(array('controller' => 'home', 'action' => 'index'));
					$this->logout();
					break;
				case User::INACTIVE:
					//TODO ユーザに「アカウントの状態がinactive」メッセージを表す
					$this->logout();
					$this->redirect(array('controller' => 'home', 'action' => 'index'));
					break;
				case User::ACTIVED:
					//TODO Verifycodeを入力要求
					$this->processRequireVerifycode($user);
					break;
			}
		}else{ // データベースの中にユーザ名が既存しない場あい、ログインをもう一度する
			$this->deleteSessionLockTime();
			$this->deleteSessionWrongPasswordTime();
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}

	// verify codeの入力要求
	protected function processRequireVerifycode($user){
		switch($user['User']['role']){
			case User::TEACHER:
				$teacherController = new TeachersController;
				$this->redirect(array('controller' => 'teachers', 'action' => 'confirm_verify_code',$user['Teacher']['id']));
				break;
			case User::STUDENT:
				//TODO ユーザが学生の場合、ログインをもう一度する（学生がverify codeがない）
				$this->logout();
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
				break;
		}
	}

	// アカウントがactiveしないページに移動する
	protected function renderUserInactive(){
		//$this->logout();
		$this->render("/Users/user_inactive");
	}

	// アカウントが禁止したページに移動する
	protected function renderUserBaned(){
		//$this->logout();
		$this->render("/Users/user_inactive");
	}

	// アカウントが仮想ロックページに移動する
	protected function renderLockTime($lock_time, $total_lock_time){
		$this->set("temp_lock_time", $lock_time);
		$this->set('total_lock_time',$total_lock_time);
		$this->render('/Users/temp_lock_user');
	}

	// ログアウト
	function logout(){

		$this->User->id = $this->Auth->user('id');
		$this->User->saveField('login_status', 'off');
		
		$this->Auth->logout();
		$this->redirect('login');

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

