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
	public $layout = 'default';
	
	public $components = array(
		'Session',
		'Auth',
		'RequestHandler'
	
//		'Auth' => array(
	//'loginAction' => array('controller' => 'home', 'action' => 'index'),
	//'loginRedirect' => array('controller' => 'home', 'action' => 'index'),
//			'logoutRedirect' => array('controller' => 'home', 'action' => 'index'),
//			'authError' => 'Bạn không có quyền truy cập trang này',
//			'authorize' => 'Controller',
//			'authenticate' => array(		
//				'Form' => array(
//					'fields' => array('username' => 'username', 'password' => 'password'),
//					'userModel' => 'User'))
//		)
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
	
    public function beforeFilter(){
    	//$this->Auth->allow();
    	
    if (isset($this->request->params['admins'])) {
            // the user has accessed an admin function, so handle it accordingly.
        
        //$this->Auth->loginRedirect = array('controller'=>'users','action'=>'index');
        $this->Auth->allow('login');
    } else {
            // the user has accessed a NON-admin function, so handle it accordingly.
       // $this->Auth->allow();

    }
    
    if($this->Auth->loggedIn()){
			$this->set('current_user', $this->Auth->user());
		}
    }
}