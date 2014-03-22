<?php
App::import('Model','Teacher');
App::import('Controller','Users');
class TestsController extends AppController{
	public $layout = "teacher";
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	//pdf, doc, docx, ppt, pptx
	const TEXT_SIZE = 5000000;
	//image
	const IMAGE_SIZE = 5000000;
	//video
	const VIDEO_SIZE = 200000000;
	//audio
	const AUDIO_SIZE = 50000000;
	//test file
	const TEST_SIZE = 2000000;
	
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
	
	public function upload_new_test($courseId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					));
		}
		
 		$this->loadModel('Teacher');
 		//先生の情報
 		$teacherID = $this->Auth->user('id');
 		
 		//リクエスト処理
 		if ($this->request->is ('post') && !empty($this->data)){
// 			debug($this->data);
 			//ファイルフォーマットチェック
			if($this->data['Test']['name']!="" && $_FILES['testFile']['name']!=""){
				// ファイル延長
				$ext = strtolower ( trim ( substr ( $_FILES['testFile']['name'], strrpos ( $_FILES['testFile']['name'], "." ) + 1, strlen ( $_FILES['testFile']['name'] ) ) ) );
				if ($ext=='tsv') {
					$new_name = "files/tests/test_".$teacherID."_".time().".".$ext;
					$data['Test'] = array(
						'course_id' => $courseId,
						'name' => $this->data['Test']['name'],
						'path' => $this->webroot.$new_name,
						'status' => 'active'
					);
				}else {
					$this->Session->setFlash ( "テストファイルはTSVではありません。" );
					return;
				}
 			}
 			//ファイル大きさチェック
			if($_FILES['testFile']['size']>self::TEST_SIZE){
				$this->Session->setFlash ( "テストの大きさが以外2Mb!" );
				return;
			}
			
			$testsPath = array(
				'tmp_name' => $_FILES['testFile']['tmp_name'],
				'name' => $new_name
			);
			
 			//ログ
			$this->writeLog(array(
				'id' => 'LOG_270',
	            'time' => time(),
	            'actor' => $this->Auth->user ( 'id' ),
	            'action' => '新しいテストファイルアップロード',
	            'content' => '先生 '.$this->Auth->user('id').' は新しいテストファイルをレーアップロードしたい',
	            'type' => 'オペレーション'
			));
			//データベースセーブ
			$dataSource = $this->Test->getDataSource();
			try{
				$dataSource->begin();
				if(!$this->Test->save($data['Test'])){
					$this->Session->setFlash ( "データベースに、追加できません。" );
					throw new Exception();
				}
				if (!move_uploaded_file ( $testsPath['tmp_name'], WWW_ROOT . $testsPath['name'])){
					//ログ
					$this->writeLog(array(
						'id' => 'LOG_043',
			            'time' => time(),
			            'actor' => 'システム',
			            'action' => 'ファイルアップロード',
			            'content' => 'サーバーで '.$new_name.' のファイルはアップロードできない',
			            'type' => 'エラー'
					));
					$this->Session->setFlash ( "テストファイルがアップロードできません!" );
					throw new Exception();
				}
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_042',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => 'ファイルアップロード',
		            'content' => 'サーバーで '.$new_name.' のファイルはアップロードする',
		            'type' => 'イベント'
				));
				$dataSource->commit();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_280',
		            'time' => time(),
		            'actor' => $this->Auth->user ( 'id' ),
		            'action' => '新しいテストファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' は新しいテストファイルをレーアップロードできる',
		            'type' => 'イベント'
				));
			}catch(Exception $e){
				//$this->Session->setFlash ( "エラー、アップロードできません。" );
				$dataSource->rollback();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_290',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '新しいテストファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' は新しいテストファイルをレーアップロードできない',
		            'type' => 'エラー'
				));
			}
 		}
	}

	public function reupload_test($testId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					) );
		}
		
		$insertData=array();
		$this->loadModel('Test');
		//テスト情報とって
		$test = $this->Test->find('first',array(
			'conditions' => array('Test.id' => $testId)
		));
//		debug($test);
		
		$teacherID = $this->Auth->user('id');
		
		//古いファイル
		$oldFile = substr ( $test['Test']['path'], strrpos ( $test['Test']['path'], "/" ) + 1, strlen ( $test['Test']['path'] ) );
		echo $oldFile;
//		debug($test);
		$this->set("data",$test);

		//リクエスト処理
		if ($this->request->is ('post') && !empty($this->data)){
//			debug($this->data);
//			debug($_FILES);
			if($this->data['Test']['name']!="" && $_FILES['testFile']['name']!=""){
				// ファイル延長
				$ext = strtolower ( trim ( substr ( $_FILES['testFile']['name'], strrpos ( $_FILES['testFile']['name'], "." ) + 1, strlen ( $_FILES['testFile']['name'] ) ) ) );
				if ($ext=='tsv') {
					$new_name = "files/tests/test_".$teacherID."_".time().".".$ext;
					$data['Test'] = array(
						'id' => $testId,
						'course_id' => $test['Test']['course_id'],
						'name' => $this->data['Test']['name'],
						'path' => $this->webroot.$new_name,
						'status' => 'active'
					);
				}else {
					$this->Session->setFlash ( "テストファイルはTSVではありません。" );
					return;
				}
				//ファイル大きさチェック
				if($_FILES['testFile']['size']>self::TEST_SIZE){
					$this->Session->setFlash ( "テストの大きさが以外2Mb!" );
					return;
				}
	
				$testsPath = array(
					'tmp_name' => $_FILES['testFile']['tmp_name'],
					'name' => $new_name
				);
//				debug($testsPath);
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_300',
		            'time' => time(),
		            'actor' => $this->Auth->user ( 'id' ),
		            'action' => 'レーテストファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' はテストの　 '.$testId.'にレーアップロードしたい',
		            'type' => 'オペレーション'
				));
				//データベースセーブ
				$dataSource = $this->Test->getDataSource();
				try{
					$dataSource->begin();
					if(!$this->Test->save($data['Test'])){
						$this->Session->setFlash ( "データベースに、追加できません。" );
						throw new Exception();
					}
					if (!move_uploaded_file ( $testsPath['tmp_name'], WWW_ROOT . $testsPath['name'])){
						//ログ
						$this->writeLog(array(
							'id' => 'LOG_045',
				            'time' => time(),
				            'actor' => 'システム',
				            'action' => 'レーファイルアップロード',
				            'content' => 'サーバーで '.$new_name.' のレーファイルはアップロードできない',
				            'type' => 'エラー'
						));
						$this->Session->setFlash ( "テストファイルがアップロードできません!" );
						throw new Exception();
					} else {
						//ログ
						$this->writeLog(array(
							'id' => 'LOG_044',
				            'time' => time(),
				            'actor' => 'システム',
				            'action' => 'レーファイルアップロード',
				            'content' => 'サーバーで '.$new_name.' のレーファイルはアップロードする',
				            'type' => 'イベント'
						));
						//古いファイル削除
						if(file_exists(WWW_ROOT ."files/tests/". $oldFile)){
							unlink(WWW_ROOT ."files/tests/". $oldFile);
						}
					}
					$dataSource->commit();
					//ログ
					$this->writeLog(array(
						'id' => 'LOG_310',
			            'time' => time(),
			            'actor' => 'システム',
			            'action' => 'レーテストファイルアップロード',
			            'content' => '先生 '.$this->Auth->user('id').' はテストの　 '.$testId.'にレーアップロードできる',
			            'type' => 'イベント'
					));
				}catch(Exception $e){
					//$this->Session->setFlash ( "エラー、アップロードできません。" );
					$dataSource->rollback();
					//ログ
					$this->writeLog(array(
						'id' => 'LOG_320',
			            'time' => time(),
			            'actor' => 'システム',
			            'action' => 'レーテストファイルアップロード',
			            'content' => '先生 '.$this->Auth->user('id').' はテストの　 '.$testId.'にレーアップロードできません',
			            'type' => 'エラー'
					));
				}
			}
		}
	}
}