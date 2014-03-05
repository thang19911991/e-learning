<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
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

class UsersController extends AppController {
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add');
	}
	
	function admin_login(){
		

		
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
						$this->Session->setFlash(__('Invalid IP address'));
					}
				} else {
					$this->Auth->logout();					
					$this->Session->setFlash(__('Invalid username or password'));     
				}
				
			} else {
				$this->Session->setFlash(__('Invalid username or password'));     
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
	
	function login() {
	if($this->Session->check('Auth.User')) {
            $this->redirect(array('action' => 'index'));
        }			
		
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
	
	function index() {
			
	}
	
	function logout(){
		$this->User->id = $this->Auth->user('id');
		$this->User->saveField('login_status', 'off');
		
		$this->Auth->logout();
		$this->redirect('login');
	}
	
	function redirectUser($user){
	switch ($user['role']){
                	case 'admin': $this->redirect(array('controller' => 'admins', 'action' => 'index'));
                				break;
                    case 'teacher': $this->redirect(array('controller' => 'teachers', 'action' => 'index'));
                				break;
                	case 'student': $this->redirect(array('controller' => 'student', 'action' => 'index'));
                				break;
                }
	}
	
	function add(){
		if($this->request->is('post')){
    		$this->User->create();
    		$user = $this->request->data;
    		//var_dump($user);
    		if($this->User->save($this->request->data)){
    			$this->Session->setFlash(__('The user has been saved'));
    			return $this->redirect(array('action' => 'index'));
    		}
			$this->Session->setFlash(__('The User could not be saved. Please try again'));
    	}
		
	}
	
	
}