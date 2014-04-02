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
		if($this->Auth->user('role') != 'admin') {
			$this->redirect(array('controller' => 'users', 'action' => 'restrict_area'));
		}
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
		$this->writeLog(array(
            'id' => 'AD_LOG_03_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Create an admin user',
            'content' => 'Admin: '.$this->Auth->user('id').' created an admin user',
            'type' => 'operation'
        ));
		
		if($this->request->is('post')){
			$create_data = $this->request->data;
			$create_data['User']['active_status'] = 'active';
			$create_data['User']['login_status'] = 'off';
			$create_data['User']['role'] = 'admin';
			$create_data['User']['password'] = AuthComponent::password($create_data['User']['username']."+".$create_data['User']['password']."+t01");
			$create_data['User']['primary_password'] = AuthComponent::password($create_data['User']['username']."+".$create_data['User']['password']."+t01");
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
			

		} else {
			$this->redirect(array("controller" => "admins", "action" => "index"));
		}
	}
	
	public function delete_document(){
		
		$this->writeLog(array(
            'id' => 'AD_LOG_14_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Delete a document',
            'content' => 'Admin: '.$this->Auth->user('id').'Delete document has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
        
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
		$this->writeLog(array(
            'id' => 'AD_LOG_15_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Active a document',
            'content' => 'Admin: '.$this->Auth->user('id').'Active document has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
		
		if(isset($this->params['named']['id'])){
			$this->Document->id = $this->params['named']['id'];
			$this->Document->saveField('status', 'active');
			$this->redirect(array("controller" => "admins", "action" => "document_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	public function deactive_document(){
		$this->writeLog(array(
            'id' => 'AD_LOG_16_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Deactive a document',
            'content' => 'Admin: '.$this->Auth->user('id').'Deactive document has id: '.$this->params['named']['id'] ,
            'type' => 'operation'
        ));
		
		if(isset($this->params['named']['id'])){
			$this->Document->id = $this->params['named']['id'];
			$this->Document->saveField('status', 'inactive');
			$this->redirect(array("controller" => "admins", "action" => "document_detail", "id" => $this->params['named']['id']));	
		} else {
			$this->redirect(array("controller" => "admins", "action" => "course_manager"));
		}
	}
	
	
	public function system_manager(){
		$this->writeLog(array(
            'id' => 'AD_LOG_33_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View system parameters',
            'content' => 'Admin: '.$this->Auth->user('id').'View system parameters' ,
            'type' => 'operation'
        ));
		$system = $this->SystemParam->find('all');
		$this->set(compact('system'));
		
		
	}	
	
	public function edit_system(){
		
		if($this->request->is('post')){
			$this->writeLog(array(
	            'id' => 'AD_LOG_34_001',
	            'time' => time(),
	            'actor' => $this->Auth->user('id'),
	            'action' => 'Edit system parameters',
	            'content' => 'Admin: '.$this->Auth->user('id').'Edit system parameters' ,
	            'type' => 'operation'
       		 ));
		
			
			
			
			$data2save = array();
			foreach ($this->data['SystemParam'] as $key => $value){
				$system_param['SystemParam'] = array();
				$system_param['SystemParam']['name'] = $key;
				$system_param['SystemParam'] ['value'] = $value;
				array_push($data2save, $system_param); 
			}
			
			$this->SystemParam->query('TRUNCATE system_params;');	
			$this->SystemParam->saveAll($data2save);
			$this->Session->setFlash("System parameter update successfully");
			$this->redirect(array('controller' => 'admins', 'action' => 'system_manager'));
			
		
		} else {
			$system = $this->SystemParam->find('all');
			$this->set(compact('system'));
		} 
	}
	
	public function backup_database() {
		$this->writeLog(array(
            'id' => 'AD_LOG_35_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Backup system database',
            'content' => 'Admin: '.$this->Auth->user('id').'Backup system database' ,
            'type' => 'operation'
       	));
		
		$this->autoRender = false;
		$databaseName = 'e_learning';
		$fileName = ROOT.'/app/webroot/files/db/'.$databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
		
		exec('mysqldump --user=root --password=123456 --host=localhost e_learning > '.$fileName);
		$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
	}
	
	public function restore_database() {
		$this->writeLog(array(
            'id' => 'AD_LOG_36_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Restore system database',
            'content' => 'Admin: '.$this->Auth->user('id').'Restore system database' ,
            'type' => 'operation'
       	 ));
		
		$this->autoRender = false;
		if(isset($this->params['named']['file'])){
				
			$mysql_host = 'localhost';
		    $mysql_username = 'root';
		    $mysql_password = '123456';
		    $db_name = 'e_learning';
			$source = ROOT.'/app/webroot/files/db/'.$this->params['named']['file'];
			
			exec("mysql -u $mysql_username -p$mysql_password $db_name < $source");
		}
		$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
	//	exec("mysql --opt -h $mysql_host -u $mysql_username -p $mysql_password $db_name < $source");
	}
	
	public function delete_file(){
		$this->writeLog(array(
            'id' => 'AD_LOG_37_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Delete backup file',
            'content' => 'Admin: '.$this->Auth->user('id').'Delete backup file' ,
            'type' => 'operation'
       	 ));
       	 
       	 
		$this->autoRender = false;
		if(isset($this->params['named']['file'])){
			$source = ROOT.'/app/webroot/files/db/'.$this->params['named']['file'];
			unlink($source);
		}
		$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
		
	}
	
	public function delete_all(){
		$this->writeLog(array(
            'id' => 'AD_LOG_38_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Delete all backup file',
            'content' => 'Admin: '.$this->Auth->user('id').'Delete all backup file' ,
            'type' => 'operation'
       	 ));
		
		
		$this->autoRender = false;
		$dir = new Folder(WWW_ROOT.'files/db');
		$dir->chmod(WWW_ROOT.'files/db',0777, true, array());
    	$files = $dir->find('.*\.sql');
    	foreach ($files as $file) {
    		unlink($dir->pwd().DS.$file);    		
    	}
    	
    	$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
	}
	 		
	public function database_mysql_dump($tables = '*') {
	
	    $return = '';
	
	    $modelName = $this->modelClass;
	
	    $dataSource = $this->User->getDataSource();
	    $databaseName = $dataSource->getSchemaName();
	
	
	    // Do a short header
	    $return .= '-- Database: `' . $databaseName . '`' . "\n";
	    $return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";
	
	
	    if ($tables == '*') {
	        $tables = array();
	        $result = $this->{$modelName}->query('SHOW TABLES');
	        foreach($result as $resultKey => $resultValue){
	            $tables[] = current($resultValue['TABLE_NAMES']);
	        }
	    } else {
	        $tables = is_array($tables) ? $tables : explode(',', $tables);
	    }
	
	    // Run through all the tables
	    foreach ($tables as $table) {
	        $tableData = $this->{$modelName}->query('SELECT * FROM ' . $table);
	
	        $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
	        $createTableResult = $this->{$modelName}->query('SHOW CREATE TABLE ' . $table);
	        $createTableEntry = current(current($createTableResult));
	        $return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";
	
	        // Output the table data
	        foreach($tableData as $tableDataIndex => $tableDataDetails) {
	
	            $return .= 'INSERT INTO ' . $table . ' VALUES(';
	
	            foreach($tableDataDetails[$table] as $dataKey => $dataValue) {
	
	                if(is_null($dataValue)){
	                    $escapedDataValue = 'NULL';
	                }
	                else {
	                    // Convert the encoding
	                    $escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );
	
	                    // Escape any apostrophes using the datasource of the model.
	                    $escapedDataValue = $this->{$modelName}->getDataSource()->value($escapedDataValue);
	                }
	
	                $tableDataDetails[$table][$dataKey] = $escapedDataValue;
	            }
	            $return .= implode(',', $tableDataDetails[$table]);
	
	            $return .= ");\n";
	        }
	
	        $return .= "\n\n\n";
	    }
	
	    // Set the default file name
	    $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
	
	    // Serve the file as a download
	    $this->autoRender = false;
	    $this->response->type('Content-Type: text/x-sql');
	  //  $this->response->download($fileName);
	   // $this->response->body($return);
	    file_put_contents( ROOT.'/app/webroot/files/db/'.$fileName ,$return);
	}
		
	
	
	
	
	//--------------------------------------------------------------------------------------
	
	
public function view_profile(){
		$this->writeLog(array(
            'id' => 'AD_LOG_17_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Admin Edit profile',
            'content' => 'Admin: '.$this->Auth->user('id').' view profile',
            'type' => 'operation'
        ));
		$current_user = $this->Auth->user();
				
		$ad = $this->User->find('first', array('conditions'=>array('username'=>$current_user['username'])));
		$this->set(compact("ad"));
	}
	
	public function edit_profile(){
		$this->writeLog(array(
            'id' => 'AD_LOG_18_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Admin Edit profile',
            'content' => 'Admin: '.$this->Auth->user('id').' edit password',
            'type' => 'operation'
        ));
        $validator = $this->User->validator();
		unset($validator['credit_number']['format_of_student']);
		
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
        $this->writeLog(array(
            'id' => 'AD_LOG_19_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Change admin password',
            'content' => 'Admin: '.$this->Auth->user('id').' change password',
            'type' => 'operation'
        ));
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
		$this->writeLog(array(
            'id' => 'AD_LOG_20_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'Change Ip',
            'content' => 'Admin: '.$this->Auth->user('id').' change ip of '.$user_admin_id,
            'type' => 'operation'
        ));
        $user = $this->Auth->user();
        
		$current_user_admin_id = $this->Auth->user('id');
		
		$current_admin_login_ip = $this->request->clientIp();
		
		$user_admin = $this->User->findById($user_admin_id);
		
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
//				echo $i . ':' . $j . '<br>';
				if($this->_compare_ip($ips[$i], $ips[$j]) == true) return false;
			}
		}
		return true;
	}
	
	protected function _compare_ip($ip1 = null, $ip2 = null){
//		echo $ip1 . ': ' . $ip2;
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
    
    public function parse_tsv(){
    	
		$file_path = '/home/phihung/WorkSpace/e-learning/app/webroot/files/tests/test.tsv';
		$file_content = array();
		$questions = array();
		$test = array();
		$question_content = array();
		$tsv_file = fopen($file_path, 'r');
		while(!feof($tsv_file)){
			
			array_push($file_content,(explode("\t",fgets($tsv_file))));
			
		}
		$test['title'] = $file_content[0][1];
		$test['subtitle'] = $file_content[1][1];
		
		array_splice($file_content, 0, 4);
		$question = array();
		$temp = array();			
		$count = 0;
		
		foreach ($file_content as $key => $value) {
				
			if($value[0] == ''){
				array_push($question_content, $temp);
				$temp = array();
				continue;
			}
			array_push($temp, $value); 

		}
		
		array_pop($question_content);
		
		foreach ($question_content as $question_block){
			$question = array();
			$question['answers'] = array();
			foreach ($question_block as $key => $block){
				if($key == 0){
					$question['question'] = $block[2];
				} else if($key == sizeof($question_block)-1){
					$question['point'] = (int)$block[3];
					$correct = $block[2];
					$question['correct'] = substr($correct, 2, 1);
				} else {
					array_push($question['answers'], $block[2]);
				}
				
			}
			array_push($questions, $question);
		}
		
		$test['questions'] = $questions;
		$this->set(compact('test'));
		debug($test);die();
		

    }
    
    public function database_manager(){
    	$this->writeLog(array(
            'id' => 'AD_LOG_39_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View backup/restore screeen',
            'content' => 'Admin: '.$this->Auth->user('id').'View backup/restore screeen' ,
            'type' => 'operation'
       	 ));
    	
    	$dir = new Folder(WWW_ROOT.'files/db');
    	//debug($dir);
    	$dir->chmod(WWW_ROOT.'files/db',0777, true, array());
    	$files = $dir->find('.*\.sql');
    	//debug($files);die;
    	$files_info = array();
    	foreach ($files as $file_name) {
    		
    		$file = new File($dir->pwd().DS.$file_name);
    		$info = $file->info();
    		$info['created_date'] = date('H:i:s - d/m/Y ', $file->lastChange());
    		$info['created_time'] = $file->lastChange();
    		
    		array_push($files_info, $info);  		
    		
    	}
    	$price = array();
		foreach ($files_info as $key => $row)
		{
		    $price[$key] = $row['created_time'];
		}
		array_multisort($price, SORT_DESC, $files_info);
    	$this->set(compact('files_info'));
    	//debug($files_info);
    }
    
    public function test_login(){
//    	debug($this->Auth);
    }
	
	
}






?>
	
	
