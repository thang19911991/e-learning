<?php
class TeacherController extends AppController{
		
	public function beforeFilter(){
		parent::beforeFilter();
		//$this->Auth->allow("register");
	}
	
	public function index(){		
		$users = $this->User->find('all');
		$this->set(compact("users"));
	}
	
	public function register(){		
		$this->loadModel('VerifyCode');
		$allCode=$this->VerifyCode->find('list',array('fields' => array('question')));
		$this->set(compact('allCode'));
		
		if($this->request->is('post')){			
			// This method resets the model state for saving new information
			$this->Member->create();
			
			// dữ liệu gửi từ Form lên
			$data  = $this->request->data;
			
			// xoá phần từ repassword đi khỏi mảng để insert không bị lỗi
			unset($data['User']['repassword']);
			
			// convert định dạng của birthday
			$birthday = $data['User']['birthday'];
			unset($data['User']['birthday']);
			$data['User']['birthday'] = $birthday['year']."-".$birthday['month']."-".$birthday['day'];
			
			$data["Member"]["status"] = 0;
			$data["Member"]["active"] = 0;
			$data["Member"]["primary_password"] = $data["Member"]["password"];
			
			// luu du lieu trong Form register vao trong bang Member
			$member = $this->Member->save($data);
			if(!empty($member)){
				// hàm setFlash giúp gửi thông báo đến tất cả các action biết
				$this->Session->setFlash(__("Register successful"));
				$this->redirect(array('controller' => 'members', 'action' => 'login'));
			}else{
				$this->Session->setFlash(__("Unable to register"));
			}
		}
	}
	
	public function login(){
		// kiem tra xem Session đã tồn tại hay chua, nếu chưa thi redirect den index
		if($this->Auth->logIn()){
			return $this->redirect(array('controller' => 'members', 'action' => 'index'));
		}
		
		// Nếu mà chưa login thì cần login và lưu Session
		if ($this->request->is('post')) {
			$data = $this->request->data;
			
	        if($data){
	        	$data['User']['password'] = AuthComponent::password($data['User']['password']);
	        	// thực hiện kiểm tra username và password(đã mã hóa) trong CSDL, nếu mà ok thì
	        	// sẽ tự động lưu thông tin của user vào trong Session
	        	// hàm này mặc định là sẽ tìm trong bảng Users với 2 trường username, password
	        	// do đó mà ta cần phải cấu hình lại cái $components, cấu hình được đặt trong AppController
		        if ($this->Auth->login()) {
	                $this->Session->setFlash("Login thanh cong");
	               	return $this->redirect(array('controller' => 'members', 'action' => 'index'));
	            }else{
					$this->Cookie->write('name',1);
	            	$this->Session->setFlash(__('Invalid username or password'));
	            }
	        }
        }
	}
	
	public function logout(){
		// tự động chuyển đến URL mà đã đăng kí trong AppController.php
		// tự động xóa Session đi (trong $this->Auth->logout() đã có xóa Session)
		$this->Cookie->destroy();
		return $this->redirect($this->Auth->logout());
	}
}
?>