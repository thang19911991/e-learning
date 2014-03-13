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

				if(!empty($user)){
					$user['role'] = $user['User']['role'];
					$user['username'] = $user['User']['username'];
					
					$this->Auth->login($user);
					//	$user = $this->Auth->user();
					if($user['User']['role'] == 'admin') {
						if(strpos($user['Ip']['IP'], $this->request->clientIp()) !== false){
							$this->User->id = $user['User']['id'];
							$this->User->saveField('login_status','on');
							$this->Session->setFlash(__('You logged in successfully'));
							$this->redirect('/admins');
						} else {
							$this->Auth->logout();
							$this->Session->setFlash(__('Invalid IP address'));
						}
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
	
		
		$params = $this->getSystemParams();

		if($params!=FALSE){
			// ロック時間があるかどうかチェック
			if($this->Session->check(parent::TempLock_time)){
				$locked_time = $params[SystemParam::TEMP_LOCK_TIME] - (time()-$this->readSessionLockTime());
				if($locked_time>0){
					$this->renderLockTime($locked_time, $params['LOCK_TIME']);
				}else{
					// Session Wrong Passwordを削除
					$this->deleteSessionWrongPasswordTime();
					// ユーザに60秒ロックする後、Verify codeを入力要求(ユーザが既存の場合）
					// ユーザが既存しない場合、ログインをもう一度する
					$this->processActiveStatus();
				}
			}

			$validator = $this->User->validator();
			unset($validator['username']['unique']);
			unset($validator['password']['min_length']);
			unset($validator['password']['max_length']);

			// form postをチェック
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

				$this->User->set($this->request->data);

				if($this->User->validates()){
					// 成功なログイン
					if(!empty($user)){
						// SESSION WRONG PASSWORDを削除
						$this->deleteSessionWrongPasswordTime();
							
						// Session locktimeを削除できない。理由はユーザが先生の場合、verify codeを入力要求
						$user = $user[0];
							
						// ユーザの状態が　actived　か？
						switch($user['User']['active_status']){
							case User::ACTIVED:
								$this->Session->write("User.username",$user['User']['username']);
								$this->Session->write("User.id",$user['User']['id']);
								$this->Session->write("User.role",$user['User']['role']);

								// ユーザに何のレベルをチェック
								if($user['User']['role']==User::TEACHER){
									// ユーザがロックしているかどうかチェック
									if($user['User']['login_status']==User::LOCK_LOGIN_STATUS){ // tài khoản bị khóa
										// ユーザがロックから、Verify codeを入力要求
										$this->redirect(array('controller' => 'teachers', 'action' => 'confirm_verify_code', $user['Teacher']['id']));
									}else{
										// 前回とは違うIPアドレスをチェック
										if($user['Teacher']['last_session_ip']==$this->request->clientIp()){
											unset($user['Student']);
											$this->Auth->login($user['User']);
											$this->writeLog(array(
											'id' => 'LOG_001',
								            'time' => time(),
								            'actor' => '先生'.$this->Auth->user('id'),
								            'action' => 'ログイン',
								            'content' => '先生 '.$this->Auth->user('username').' はログインできた',
								            'type' => 'オペレーション'
								            ));
								            $this->redirect(array('controller' => 'teachers', 'action' => 'index'));
										}else{
											$this->Session->setFlash('前回とは違う別のIPアドレスです。Verifycodeを入力してください');
											$this->redirect(array('controller' => 'teachers', 'action' => 'confirm_verify_code', $user['Teacher']['id']));
										}
									}
								}else if($user['User']['role'] == User::STUDENT){
									//TODO ホームページに移動する
									unset($user['Teacher']);
									$this->Auth->login($user['User']);
									$this->writeLog(array(
											'id' => 'LOG_001',
								            'time' => time(),
								            'actor' => '学生'.$this->Auth->user('id'),
								            'action' => 'ログイン',
								            'content' => '学生 '.$this->Auth->user('username').' はログインできた',
								            'type' => 'オペレーション'
								            ));
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
							if($wrong_password_time<$params['WRONG_PASS_LIMIT']-1){
								// lưu tên username vào trong Session USER_TEMP_NAME
								$this->Session->write(parent::USER_TEMP_NAME, $this->request->data['User']['username']);
									
								$this->writeSessionWrongPasswordTime($wrong_password_time+1);
								$wrong_password_time = $this->readSessionWrongPasswordTime();
								echo "間違えたユーザ名、パスワード : ". $wrong_password_time. "回/". $params['WRONG_PASS_LIMIT'];
							}else{
								$this->writeSessionLockTime(time());
								$this->deleteSessionWrongPasswordTime();
								$this->renderLockTime($params[SystemParam::TEMP_LOCK_TIME], $params['LOCK_TIME']);
							}
						}else{
							echo "間違えたユーザ名、パスワード : 1回/5";
							$this->writeSessionWrongPasswordTime(1);
						}
					}
				}
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

