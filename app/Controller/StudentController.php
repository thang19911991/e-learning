<?php
CakePlugin::load('Uploader');
App::import('Vendor', 'Uploader.Uploader');
function uploaderFilename($name, $field, $data) {
	return $name;
}
App::uses('DboSource', 'Model/Datasource');
App::uses('CakeEmail', 'Network/Email');
?>
<?php
class StudentController extends AppController{
	//public $layout = 'default';
	function beforeFilter(){
		// gọi đến phương thức beforefFilter() của AppController.php
		parent::beforeFilter();
		//$this->Auth->allow('index');
	}
	function std_register(){
		$this->set('title_for_layout', '学生の登録ページ');
		if (!empty($this->data)) {
			$this->loadModel('User');
			$this->User->set($this->request->data);
			//  debug($this->User->validates());
			if (!$this->User->validates()) {
				unset($this->request->data['Submit']);
			}else	{
				$data  = $this->request->data;
				$files = $this->request->data['User']['profile_img'];
				$images = $files['name'];
				if (!empty($files)) {
					$data['User']['profile_img'] = $data['User']['username'].'-'.$images;
					$imageName = $data['User']['profile_img'];
					//debug($imageName);die;
					move_uploaded_file($files['tmp_name'], WWW_ROOT . 'img' .DS. 'Avatar'  .DS. $imageName);
				}else{
					$data['User']['profile_img'] = 'avatar.jpg';
				}
				$this->User->create();
				$this->User->save($data,false);
				$this->redirect(array('controller'=> 'Student','action'=>'login'));
			}
		}
	}
	function _std_login(){

	}
	function  std_logout(){

	}
	function std_index(){

	}
	
	function index(){
		
	}
}
?>