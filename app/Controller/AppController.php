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
	
	public $layout = 'home_page';
	
	public $components = array(
		'Session',
		'Auth' => array(
			//'loginAction' => array('controller' => 'home', 'action' => 'index'),
			//'loginRedirect' => array('controller' => 'teacher', 'action' => 'login'),
			'logoutRedirect' => array('controller' => 'home', 'action' => 'index'),
			'authError' => 'Bạn không có quyền truy cập trang này',
			'authorize' => 'Controller'
		)
	);
    
    public function isAuthorized($user) {
    	if($this->action=="logout"){
    		return true;
    	}
    	
	    $user = $this->Auth->user();
	    
	    if(isset($user) || !empty($user)){
	    	if($user['role']=="student"){
	    		if(in_array($this->action, array(
	    			'std_change_pass',
	    			'std_deactive',
	    			'std_detail_course',
	    			'std_edit',
	    			'std_index',
	    			'std_list_course',
	    			'std_profile',
	    			'std_search',
	    			'std_test_result',
	    			'std_try_course',
	    			'std_detail_course',
	    			'std_view_document',
	    			'std_view_test',
	    			'view_list_course',
	    			'std_logout'
	    		))){
	    			return true;
	    		}
	    		$this->redirect(array('controller' => 'student', 'action' => 'std_index'));
	    		return false;
	    	}else if($user['role']=="teacher"){
	    		if(in_array($this->action, array(
	    			'ban_student',
	    			'upload_new_test',
	    			'change_password',
	    			'change_profile',
	    			'change_secret_question',
	    			'confirm_verify_code',
	    			'convert',
	    			'course_manage',
	    			'create_new_course',
	    			'edit_course',
	    			'delete_course',
	    			'view_a_course',
	    			'view_ban_list',
	    			'view_list_course',
	    			'view_profile',
	    			'view_test_result',
	    			'delete_tag',
	    			'update_tag_course',
	    			'edit_tag',
	    			'key',
	    			'update_tag_course',
	    			'logout'
	    		))){
	    			return true;
	    		}
	    		$this->redirect(array('controller' => 'teachers', 'action' => 'index'));
	    		return false;
	    	}else{
	    		$this->Auth->allow();
	    	}
	    }else{ // 普通のユーザ
	    	//$this->redirect(array('controller' => 'home', 'action' => 'index'));
	    	return true;
	    }
	    return true;
	}
	
	public function beforeFilter(){
		$this->Session->write('user', $this->Auth->user());
        $this->set('current_user', $this->Auth->user());
    }
	
	// system_paramsテーブルの値を返却する
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
	
	/**
	 * 
	 * ファイルにログを書く
	 * 
	 * $this->writeLog(array(
     *       'id' => 'LOG_001',
     *       'time' => time(),
     *       'actor' => $this->Auth->user('id'),
     *       'action' => 'Cancel student',
     *       'content' => 'Teacher '.$this->Auth->user('id').' cancel student '.$studentId,
     *       'type' => 'operation'
     *   ));
	 */
    public function writeLog($mess){
    	//年と月と日をとって
    	$year_folder = date("Y");
    	$month_folder = date("m");
    	$day_file = "log_".$year_folder."_".$month_folder."_".date("d").".csv";
    	$base = "files/logs/";
    	
    		//チェックフォルダーとファイルが存在するか
    	if(!file_exists($base.$year_folder)){
    		mkdir($base.$year_folder,0777);
    	}
    	if(!file_exists($base.$year_folder.'/'.$month_folder)){
    		mkdir($base.$year_folder.'/'.$month_folder,0777);
    	}
    	
    	if(!file_exists($base.$year_folder.'/'.$month_folder.'/'.$day_file)){
    		//新しいログファイル作成
    		$handle = fopen($base.$year_folder.'/'.$month_folder.'/'.$day_file, "w+");
    		chmod($base.$year_folder.'/'.$month_folder.'/'.$day_file, 0777);
    		$line1 = '"id","time","actor","action","content","type"';
    		fwrite($handle, $line1);
    	} else {
    		//存在ファイルopen
    		$handle = fopen($base.$year_folder.'/'.$month_folder.'/'.$day_file, "a+");
    	}
    		//ログを書く
    	fwrite($handle,"\n");
    	$str = '"'.$mess['id'].'","'.$mess['time'].'","'.$mess['actor'].'","'.$mess['action'].'","'.$mess['content'].'","'.$mess['type'].'"';
    	fwrite($handle,$str);
    		//ファイルを占める
    	fclose($handle);
    }
}