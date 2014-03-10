<?php
class TestsController extends AppController{
	
	/**
	 * テストを削除
	 * @param int $test_id
	 */
	public function delete_test(){
		$this->autoRender = false;
		
		$test_id = $_POST['test_id'];
		
		if($test_id){
			$this->loadModel('Test');

			$this->Test->recursive = -1;
			$test = $this->Test->find('first', array(
				'conditions' => array(
					'Test.id' => $test_id
				)
			));
			
			$path = $test['Test']['path'];
			$str = explode("/", $path);
			$size = count($str);
			if($size>0){
				$file_name = $str[$size-1];
			}
			
			$file = new File(WWW_ROOT.'files/tests/'.$file_name);
			
			$flag =  $file->delete();
			if(empty($flag)){
				try{
					// テストを削除
					$this->Test->delete($test_id);
					return new CakeResponse(array('body' => "ok"));
				}catch (Exception $e){
					return new CakeResponse(array('body' => "not_ok"));
				}
			}
		}else{
			return new CakeResponse(array('body' => "not_ok"));
		}
	}
}