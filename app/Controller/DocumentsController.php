<?php
App::import('Model','Teacher');
App::import('Controller','Users');
class DocumentsController extends AppController{
	public $layout = "teacher";
	public $helpers = array (
			"Html",
			"Session",
			"Form",
			"Paginator",
			"Js" => array ("JQuery")
	);
	
	public $components = array ("Session", "RequestHandler", "Auth");
	
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
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	/*
	 * 授業のドキュメントレーアップロード
	 */
	public function reupload_document($documentId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login'
			));
		}
		
		$insertData=array();
		$this->loadModel('Document');
		//ドキュメント情報とって
		$document = $this->Document->find('first',array(
			'conditions' => array('Document.id' => $documentId)
		));
		//古いファイル
		$oldFile = substr ( $document['Document']['path'], strrpos ( $document['Document']['path'], "/" ) + 1, strlen ( $document['Document']['path'] ) );
		$this->set("data",$document);

		//リクエスト処理
		if ($this->request->is ('post') && !empty($this->data)){
			//ファイルフォーマットチェック
			if($this->data['Document']['name']!="" && $_FILES['documentFile']['name']!=""){
				$array_ext = array (
						'jpg','jpeg','png','pdf','mp3','mp4','wma','flv'
						);
						//ファイル延長
						$ext = strtolower ( trim ( substr ( $_FILES['documentFile']['name'], strrpos ( $_FILES['documentFile']['name'], "." ) + 1, strlen ( $_FILES['documentFile']['name'] ) ) ) );
						// ファイル延長チェック
						if (in_array ( $ext, $array_ext )) {
							$new_name = "files/documents/doc_".$document['Course']['teacher_id']."_".time().".".$ext;

						}else {
							$this->Session->setFlash ( "ファイルの延長はサポートしません。" );
							return;
						}
						//ファイル大きさチェック
						switch($ext){
							case 'jpg':
							case 'png':
							case 'jpeg':
								if($_FILES['documentFile']['size']>self::IMAGE_SIZE){
									$this->Session->setFlash ( "イメージファイルの大きさが以外5Mb。" );
									return;
								}
								break;
							case 'pdf':
								if($_FILES['documentFile']['size']>self::TEXT_SIZE){
									$this->Session->setFlash ( "テキスト (pdf) ファイルの大きさが以外5Mb。" );
									return;
								}
								break;
							case 'mp3':
								if($_FILES['documentFile']['size']>self::AUDIO_SIZE){
									$this->Session->setFlash ( "オーディオ(mp3)ファイルの大きさが以外50Mb。" );
									return;
								}
								break;
							case 'mp4':
							case 'flv':
							case 'wma':
								if($_FILES['documentFile']['size']>self::VIDEO_SIZE){
									$this->Session->setFlash ( "ビデオ(mp4, flv, wma)ファイルの大きさが以外200Mb!" );
									return;
								}
								break;
						}
			}
			//セットデータ
			$insertData['Document']['id'] = $document['Document']['id'];
			$insertData['Document']['name'] = $this->data['Document']['name'];
			$insertData['Document']['path'] = $this->webroot.$new_name;
			debug($insertData);
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_030',
	            'time' => time(),
	            'actor' => $this->Auth->user ( 'id' ),
	            'action' => 'レーファイルアップロード',
	            'content' => '先生 '.$this->Auth->user('id').' はドキュメントの　 '.$documentId.'にレーファイルをアップロードしたい',
	            'type' => 'オペレーション'
			));
			//データベースセーブ
			$dataSource = $this->Document->getDataSource();
			try{
				$dataSource->begin();
				//データベースセーブ
				$this->Document->save($insertData);
				//ファイルアップロード
				if (!move_uploaded_file ( $_FILES['documentFile']['tmp_name'], WWW_ROOT . $new_name)){
					//ログ
					$this->writeLog(array(
						'id' => 'LOG_045',
			            'time' => time(),
			            'actor' => 'システム',
			            'action' => 'レーファイルアップロード',
			            'content' => 'サーバーで '.$new_name.' のれーファイルはアップロードできない',
			            'type' => 'エラー'
					));
					$this->Session->setFlash ( "ドキュメントファイルがアップロードできません!" );
					throw new Exception();
				} else {
					//ログ
					$this->writeLog(array(
						'id' => 'LOG_044',
			            'time' => time(),
			            'actor' => 'システム',
			            'action' => 'レーファイルアップロード',
			            'content' => 'サーバーで '.$new_name.' のれーファイルはアップロードする',
			            'type' => 'イベント'
					));
					//古いファイル削除
					unlink(WWW_ROOT ."files/documents/". $oldFile);
				}
				$dataSource->commit();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_031',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => 'レーファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' はドキュメントの　 '.$documentId.'にレーファイルをアップロードできる',
		            'type' => 'イベント'
				));
				
				return $this->redirect(array('controller' => 'teachers', 'action' => 'view_a_course', $documentId));
			}catch(Exception $e){
				$this->Session->setFlash ( "エラー、アップロードできません" );
				$dataSource->rollback();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_032',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => 'レーファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' はドキュメントの　 '.$documentId.'にレーファイルをアップロードできない',
		            'type' => 'エラー'
				));
			}
		}
	}
	
	/*
	 * 新しいドキュメントアップロード
	 */
	public function upload_new_document($courseId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					) );
		}
 		$this->loadModel('Teacher');
 		//先生の情報
 		
 		$_teacher = $this->Teacher->find("first",array(
 			'conditions' => array("Teacher.user_id" => $this->Auth->user('id')),
 			'fields' =>array("Teacher.id")
 		));
// 		debug($teacherId);
		$teacherId = $_teacher['Teacher']['id'];
 		
		$data['Document'] = array();
		//リクエスト処理
		if ($this->request->is ('post') && !empty($this->data)){
//			debug($this->data);
//			debug($_FILES);
			//ファイルフォーマットチェック
			if($this->data['Document']['name']!="" && $_FILES['documentFile']['name']!=""){
				$array_ext = array (
					'jpg','jpeg','png','pdf','mp3','mp4','wma','flv'
				);
				//ファイル延長とって
				$ext = strtolower ( trim ( substr ( $_FILES['documentFile']['name'], strrpos ( $_FILES['documentFile']['name'], "." ) + 1, strlen ( $_FILES['documentFile']['name'] ) ) ) );
				//延長チェック
				if (in_array ( $ext, $array_ext )) {
					$new_name = "files/documents/doc_".$teacherId."_".time().".".$ext;
				}else {
					$this->Session->setFlash ( "ファイルの延長はサポートしません。" );
					return;
				}

				switch($ext){
					case 'jpg':
					case 'png':
					case 'jpeg':
						if($_FILES['documentFile']['size']>self::IMAGE_SIZE){
							$this->Session->setFlash ( "イメージファイルの大きさが以外5Mb。" );
							return;
						}
						break;
					case 'pdf':
						if($_FILES['documentFile']['size']>self::TEXT_SIZE){
							$this->Session->setFlash ( "テキスト (pdf) ファイルの大きさが以外5Mb。" );
							return;
						}
						break;
					case 'mp3':
						if($_FILES['documentFile']['size']>self::AUDIO_SIZE){
							$this->Session->setFlash ( "オーディオ(mp3)ファイルの大きさが以外50Mb。" );
							return;
						}
						break;
					case 'mp4':
					case 'flv':
					case 'wma':
						if($_FILES['documentFile']['size']>self::VIDEO_SIZE){
							$this->Session->setFlash ( "ビデオ(mp4, flv, wma)ファイルの大きさが以外200Mb!" );
							return;
						}
						break;
				}
			}
			$data['Document']['path'] =$this->webroot.$new_name;
			$data['Document']['name'] = $this->data['Document']['name'];
			$data['Document']['type'] = $ext;
			$data['Document']['course_id'] = $courseId;
			$data['Document']['status'] = 1;
//			debug($data);
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_027',
	            'time' => time(),
	            'actor' => $this->Auth->user ( 'id' ),
	            'action' => '新しいファイルアップロード',
	            'content' => '先生 '.$this->Auth->user('id').' は授業 '.$courseId.'に新しいドキュメントファイルをアップロードしたい',
	            'type' => 'オペレーション'
			));
			$dataSource = $this->Document->getDataSource();
			try{
				$dataSource->begin();
				$this->Document->save($data);				
				if (!move_uploaded_file ( $_FILES['documentFile']['tmp_name'], WWW_ROOT . $new_name)){
					//ログ
					$this->writeLog(array(
						'id' => 'LOG_043',
			            'time' => time(),
			            'actor' => 'システム',
			            'action' => 'ファイルアップロード',
			            'content' => 'サーバーで '.$new_name.' のファイルはアップロードできない',
			            'type' => 'エラー'
					));
					$this->Session->setFlash ( "ドキュメントファイルがアップロードできません!" );
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
					'id' => 'LOG_028',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '新しいファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' は授業 '.$courseId.'に新しいドキュメントファイルをアップロードできる',
		            'type' => 'イベント'
				));
			}catch(Exception $e){
				$this->Session->setFlash ( "エラー、アップロードできません" );
				$dataSource->rollback();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_029',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '新しいファイルアップロード',
		            'content' => '先生 '.$this->Auth->user('id').' は授業 '.$courseId.'に新しいドキュメントファイルをアップロードできない',
		            'type' => 'エラー'
				));
			}
		}
	}
	
	/**
	 * ドキュメントを削除
	 * @param int $document_id
	 */
	public function delete_document(){
		$this->autoRender = false;
		
		$document_id = $_POST['document_id'];
		
		if($document_id){
			$this->loadModel('Document');
			$this->loadModel('StudentDocumentReport');
			
			$this->Document->recursive = -1;
			$document = $this->Document->find('first', array(
				'conditions' => array(
					'Document.id' => $document_id
				)
			));
			
			$path = $document['Document']['path'];
			$str = explode("/", $path);
			$size = count($str);
			if($size>0){
				$file_name = $str[$size-1];
			}
						
			$file = new File(WWW_ROOT.'files/documents/'.$file_name);
			
			$flag =  $file->delete();
			if(empty($flag)){
				try{
					// ドキュメントを削除
					$this->Document->delete($document_id);
						
					// ドキュメントのレポートを削除
					$sql = "DELETE FROM students_documents_report WHERE document_id=".$document_id;
					$this->StudentDocumentReport->query($sql);
					
					return new CakeResponse(array('body' => "ok"));
				}catch (Exception $e){
					$this->writeLog(array(
						'id' => 'LOG_021',
						'time' => time(),
						'actor' => '先生'.$this->Auth->user('id'),
						'action' => 'ドキュメント削除',
						'content' => 'DocumentID（'.$document_id.')'.' が削除した',
						'type' => 'オペレーション'
					));
					$this->writeLog(array(
						'id' => 'LOG_022',
						'time' => time(),
						'actor' => 'システム',
						'action' => 'ドキュメント削除',
						'content' => 'データベースでDocumentID（'.$document_id.')'.' が削除した',
						'type' => 'イベント'
					));
					return new CakeResponse(array('body' => "not_ok"));
				}
			}
		}else{
			return new CakeResponse(array('body' => "not_ok"));
		}
	}
}