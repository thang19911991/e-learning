<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	const TempLock_time 			= "TempLock.time"; // dùng để lưu thời gian lock tạm thơi
	const Login_wrong				= "Login.wrong";	// lưu số lần login sai
	const TempLock					= "TempLock";		// dùng để lưu thời gian lock tạm thơi
	const Login						= "Login";			// lưu số lần login sai
	const USER_TEMP_NAME			= "UserTemp.username";	// username tam thời
	
	public $layout = 'default';
	
	public $components = array(
		'Session',
		'Auth' => array(
			//'loginAction' => array('controller' => 'home', 'action' => 'index'),
			//'loginRedirect' => array('controller' => 'teacher', 'action' => 'login'),
			'logoutRedirect' => array('controller' => 'home', 'action' => 'index'),
			'authError' => 'Bạn không có quyền truy cập trang này',
			'authorize' => 'Controller',
			'authenticate' => array(		
				'Form' => array(
					'fields' => array('username' => 'username', 'password' => 'password'),
					'userModel' => 'User'))
		)
	);
    
    public function isAuthorized($user) {
		return true;
	    // Admin can access every action
	    /*if (isset($user['role']) && $user['role'] === 'admin') {
	        return true;
	    }
	
	    // Default deny
	    return false; */
	}
	
	// tra ve thong so trong bang system_params
	function getSystemParams(){
		$this->loadModel('SystemParam');
		$paramNames = array(
			SystemParam::TEMP_LOCK_TIME,
			SystemParam::MAX_TIME_WRONG_PASSWORD,
			SystemParam::KOMA_COST,
			SystemParam::KOMA_TIMEOUT,
			SystemParam::MAX_AVATAR_SIZE,
			SystemParam::MAX_COURSE_FILE_SIZE,
			SystemParam::MAX_LENGTH_INPUT,
			SystemParam::MIN_LENGTH_PASSWORD,
			SystemParam::SESSION_TIMEOUT,
			SystemParam::TEACHER_PAY
		);
		
		$systemParams = $this->SystemParam->find("all", array(
			'fields'		=>	array('name', 'value'),
			'conditions'	=>	array(				
				'name'		=>	$paramNames
			)
		));
		
		if(!empty($systemParams)){
			$params = array();
			foreach ($systemParams as $data) {				
				$params[$data['SystemParam']['name']] = $data['SystemParam']['value'];
			}
			return $params;
		}else{
			return FALSE;
		}
	}
	
    public function beforeFilter(){
    	$this->Auth->allow();
        $this->set('current_user', $this->Auth->user());
    }
}