<?php
App::import('Model','Teacher');
App::import('Controller','Users');

class TeachersController extends AppController{	
	public $components = array ("RequestHandler");
	public $name = "Teachers";

	public $helpers = array (
			"Html",
			"Session",
			"Form",
			"Paginator",
			"Js" => array ("JQuery")
	);

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

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('register','login','index');
	}
	
	public function index(){
		$this->loadModel("User");
		$users = $this->User->find('all',array(
			'fields' => array(
					'User.id',
					'User.username',
					'User.full_name',
					'User.birthday',
					'User.address',
					'User.role'
				)
			)
		);
		$this->set(compact("users"));
	}	
	
	// コースを禁止するのを停止
	public function course_unban() {
		$this->loadModel ( "StudentCourseLearn" );
		$this->loadModel ( "StudentCourseBan" );
		if(isset($this->params['url']['student_id']))
			$student_id= $this->params['url']['student_id'];
		if(isset($this->params['url']['course_id']))
			$course_id = $this->params['url']['course_id'];
		if(isset($this->params['url']['id']))
			$id = $this->params['url']['id'];
		$sql="DELETE FROM `e_learning`.`students_courses_ban` WHERE `student_id`='".$student_id."' AND `course_id`='".$course_id."'";
		$this->StudentCourseBan->query($sql);
		$sql="UPDATE `e_learning`.`students_courses_learn` SET `status`='learning' WHERE `id`='".$id."'";
		$this->StudentCourseLearn->query($sql);			
		return $this->redirect(array('controller' => 'teacher2', 'action' => 'course_manage',$course_id));
	}

	// コースを禁止する
	public function course_ban() {
		$this->autoRender = false;
		$this->loadModel ( "StudentCourseLearn" );
		$this->loadModel ( "StudentCourseBan" );
		$student_id = $_POST['student_id'];
		$course_id = $_POST['course_id'];
		$content = $_POST['content'];
		$learn_id=$_POST['learn_id'];
		$sql="INSERT INTO `e_learning`.`students_courses_ban` (`student_id`, `course_id`, `reason`) VALUES ('".$student_id."', '".$course_id."', '".$content."')";
		$this->StudentCourseBan->query($sql);
		$sql="UPDATE `e_learning`.`students_courses_learn` SET `status`='cancel' WHERE `id`='".$learn_id."'";
		$this->StudentCourseLearn->query($sql);
			
		return new CakeResponse(array('body' => $student_id.":".$course_id.":".$content));
	}
	
	// コース管理
	public function course_manage($id = null) {
		$this->loadModel ( "Course" );
		$this->loadModel ( "Ban" );
		$this->loadModel ( "StudentCourseLearn" );
		$this->loadModel ( "StudentCourseBan" );
		$this->loadModel ( "User" );
		$this->loadModel ( "Student" );
		$this->Course->recursive = 2;
		
		$courses = $this->Course->find ( 'first', array (
				'conditions' => array (
						'Course.id' => $id 
				) 
		) );
		
		$ban = $this->StudentCourseBan->find ( 'all', array (
				'conditions' => array (
						'StudentCourseBan.course_id' => $id 
				) 
		));
		
		
		$learn = $this->StudentCourseLearn->find ( 'all', array (
				'conditions' => array (
						'StudentCourseLearn.course_id' => $id 
				) 
		));
		
		for ($i=0; $i<count($learn);$i++){
			$_st = $this->Student->find('first',array(			
				'conditions' => array(
					'Student.id'=>$learn[$i]["StudentCourseLearn"]["student_id"])
			));
			$learn[$i]["StudentCourseLearn"]["student_name"]= $_st["User"]["username"];
		}
		$this->set ( compact ( "learn" ) );
		$this->set ( compact ( "courses" ) );
	}
	
	/*
	 * 新しい授業作成
	 */
	public function create_new_course(){
		//ログインチェック
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					) );
		}
		$this->loadModel("User");
		$this->loadModel("Teacher");
		//先生情報とって
		$teacher = $this->Teacher->find("first", array(
			'conditions' => array('user_id' => $this->Auth->user('id'))
		));
		//debug($teacher);
		if ($this->request->is ( 'post' ) && !empty($this->data)) {
			//debug( $this->request->data );
			//var_dump ($_FILES);
			$teacherID=$this->Auth->user('id');
//			echo $teacherID;
			$documentsPath = array();
			$data = array();
			$data['Course'] = $this->data['Course'];
			$data['Course']['teacher_id'] = $teacher['Teacher']['id'];
			$data['Course']['status'] = 'active';
			$data['Document']= array();

			// ドキュメントファイルフォーマットチェック
			for($i=0;$i<=$this->data['Course']['lessonFileNumber'];$i++){
				if($this->data['Course']['lessonName'.$i]!="" && $_FILES['lessonFile'.$i]['name']!=""){
					//extension
					$array_ext = array (
						'jpg','jpeg','png','pdf','mp3','mp4','wma','flv'
						);
						// ファイルextensionとって
						$ext = strtolower ( trim ( substr ( $_FILES['lessonFile'.$i]['name'],
						strrpos ( $_FILES['lessonFile'.$i]['name'], "." ) + 1,
						strlen ( $_FILES['lessonFile'.$i]['name'] ) ) ) );

						//extensionチェック
						if (in_array ( $ext, $array_ext )) {
							$new_name = "files/documents/doc_".$teacherID."_".time().".".$ext;
							$data['Document'][] = array(
								'name' => $this->data['Course']['lessonName'.$i],
								'path' => $this->webroot.$new_name,
								'status' => 'active'
							);
						}else {
							$this->Session->setFlash ( "ファイルの延長はサポートしません。" );
							return;
						}
						//ファイル大きさチェック
						switch($ext){
							case 'jpg':
							case 'png':
							case 'jpeg':
								if($_FILES['lessonFile'.$i]['size']>self::IMAGE_SIZE){
									$this->Session->setFlash ( "イメージファイルの大きさが以外5Mb。" );
									return;
								}
								break;
							case 'pdf':
								if($_FILES['lessonFile'.$i]['size']>self::TEXT_SIZE){
									$this->Session->setFlash ( "テキスト (pdf) ファイルの大きさが以外5Mb。" );
									return;
								}
								break;
							case 'mp3':
								if($_FILES['lessonFile'.$i]['size']>self::AUDIO_SIZE){
									$this->Session->setFlash ( "オーディオ(mp3)ファイルの大きさが以外50Mb。" );
									return;
								}
								break;
							case 'mp4':
							case 'flv':
							case 'wma':
								if($_FILES['lessonFile'.$i]['size']>self::VIDEO_SIZE){
									$this->Session->setFlash ( "ビデオ(mp4, flv, wma)ファイルの大きさが以外200Mb!" );
									return;
								}
								break;
						}
						$documentsPath[] = array(
						'tmp_name' => $_FILES['lessonFile'.$i]['tmp_name'],
						'name' => $new_name
						);
				}
			}

			$testsPath = array();
			$data['Test'] = array();
			// テストファイルフォーマットチェック
			for($i=0;$i<=$this->data['Course']['testFileNumber'];$i++){
				if($this->data['Course']['testName'.$i]!="" && $_FILES['testFile'.$i]['name']!=""){
					// ファイル延長
					$ext = strtolower ( trim ( substr ( $_FILES['testFile'.$i]['name'], strrpos ( $_FILES['testFile'.$i]['name'], "." ) + 1, strlen ( $_FILES['testFile'.$i]['name'] ) ) ) );
					if ($ext=='tsv') {
						$new_name = "files/tests/test_".$teacherID."_".time().".".$ext;
						$data['Test'][] = array(
							'name' => $this->data['Course']['testName'.$i],
							'path' => $this->webroot.$new_name,
							'status' => 'active'
						);
					}else {
						$this->Session->setFlash ( "テストファイルはTSVではありません。" );
						return;
					}
					//ファイル大きさチェック
					if($_FILES['testFile'.$i]['size']>self::TEST_SIZE){
						$this->Session->setFlash ( "テストの大きさが以外2Mb!" );
						return;
					}

					$testsPath[] = array(
						'tmp_name' => $_FILES['testFile'.$i]['tmp_name'],
						'name' => $new_name
					);
				}
			}

			$data['Tag'] = array();
			$tagNames = array();
			//授業タグとって
			for($i=0;$i<=$this->data['Course']['tagNumber'];$i++){
				if($this->data['Course']['tag'.$i]!=""){
					$data['Tag'][] = array(
						'tag_name' => $this->data['Course']['tag'.$i]
					);
					$tagNames[] = $this->data['Course']['tag'.$i];
				}
			}

			$this->loadModel('Course');
			$this->loadModel('Tag');
			$this->loadModel('Document');
			$this->loadModel('Test');
			$this->loadModel('CourseTag');
			
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_015',
	            'time' => time(),
	            'actor' => $this->Auth->user ( 'id' ),
	            'action' => '授業作成',
	            'content' => '先生 '.$this->Auth->user('id').' は新しい授業を作成したい',
	            'type' => 'オペレーション'
			));
		
			//セーブデータベース
			$dataSource = $this->Course->getDataSource();
			try{
				$dataSource->begin();
				//授業追加
				if($this->Course->save($data)){
					$id = $this->Course->getInsertID();
				} else {
					$this->Session->setFlash ( "データベースに追加時、エラーが発生。" );
					throw new Exception();
				}
				
				//存在しているタグ
				$existedTag = $this->Tag->find("all",array(
					'conditions' => array(
						'tag_name' => $tagNames
					)
				));
				//存在しないタグだけをとって
				$data['CourseTag'] = array();
				foreach ($existedTag as $cat){
					for ($i=0;$i<count($data['Tag']);$i++){
						if($cat['Tag']['tag_name']==$data['Tag'][$i]['tag_name']){
							unset($data['Tag'][$i]);
						}
					}
					$d = array(
						'tag_id' => $cat['Tag']['id'],
						'course_id' => $id
					);
					$data['CourseTag'][] = $d;
				}
//				debug($data['Course']);
				
				$this->Course->set($data['Course']);
				//validationチェック
				if(!$this->Course->validates()){
					return;
				}
				//タグ追加
				$new_tag_ids = array();
//				debug($data['Tag']);
				if(count($data['Tag'])!=0){
					if($this->Tag->saveMany($data['Tag'])){
						//タグIDをとって
						$new_tag_ids=$this->Tag->inserted_ids;
					} else{
						$this->Session->setFlash ( "データベースに追加時、エラーが発生。" );
						throw new Exception();
					}
				}
				//debug($new_category_ids);

				//CourseTag 追加
				foreach ($new_tag_ids as $nci){
					$d = array(
						'tag_id' => $nci,
						'course_id' => $id
					);
					$data['CourseTag'][] = $d;
				}
				if(count($data['CourseTag'])!=0){
					if(!$this->CourseTag->saveMany($data['CourseTag'])){
						$this->Session->setFlash ( "データベースに追加時、エラーが発生。" );
						throw new Exception();
					}
				}

				//ドキュメントとテストファイルにアップデートID
				for($i=0;$i<count($data['Document']);$i++){
					$data['Document'][$i]['course_id'] = $id;
				}
				for($i=0;$i<count($data['Test']);$i++){
					$data['Test'][$i]['course_id'] = $id;
				}
				//			debug($data);
				if(!$this->Document->saveMany($data['Document'])){
					$this->Session->setFlash ( "データベースに追加時、エラーが発生。" );
					throw new Exception();
				}
				if(!$this->Test->saveMany($data['Test'])){
					$this->Session->setFlash ( "データベースに追加時、エラーが発生。" );
					throw new Exception();
				}
				//ドキュメントとテストファイルをアップロード
				for ($i=0;$i<count($documentsPath);$i++){
					if (!move_uploaded_file ( $documentsPath[$i]['tmp_name'], WWW_ROOT . $documentsPath[$i]['name'])){
						//ログ
						$this->writeLog(array(
							'id' => 'LOG_043',
				            'time' => time(),
				            'actor' => 'システム',
				            'action' => 'ファイルアップロード',
				            'content' => 'サーバーで あるファイルはアップロードできない',
				            'type' => 'エラー'
						));
						$this->Session->setFlash ( "ドキュメントファイルがアップロードできません。" );
						for($j=0;$j<$i;$j++){
							//削除アップロードファイル
							unlink(WWW_ROOT . $documentsPath[$j]['name']);
						}
						throw new Exception();
					} else{
						//ログ
						$this->writeLog(array(
							'id' => 'LOG_042',
				            'time' => time(),
				            'actor' => 'システム',
				            'action' => 'ファイルアップロード',
				            'content' => 'サーバーで '.$documentsPath[$i]['name'].'ファイルはアップロードできる',
				            'type' => 'イベント'
						));
					}
				}
				for ($i=0;$i<count($testsPath);$i++){
					if (!move_uploaded_file ( $testsPath[$i]['tmp_name'], WWW_ROOT . $testsPath[$i]['name'])){
						//ログ
						$this->writeLog(array(
							'id' => 'LOG_043',
				            'time' => time(),
				            'actor' => 'システム',
				            'action' => 'ファイルアップロード',
				            'content' => 'サーバーで あるファイルはアップロードできない',
				            'type' => 'エラー'
						));
						$this->Session->setFlash ( "テストファイルがアップロードできません。" );
						for($j=0;$j<$i;$j++){
							unlink(WWW_ROOT . $testsPath[$j]['name']);
						}
						throw new Exception();
					}else{
						//ログ
						$this->writeLog(array(
							'id' => 'LOG_042',
				            'time' => time(),
				            'actor' => 'システム',
				            'action' => 'ファイルアップロード',
				            'content' => 'サーバーで '.$testsPath[$i]['name'].'ファイルはアップロードできる',
				            'type' => 'イベント'
						));
					}
				}
				$dataSource->commit();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_016',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '授業作成',
		            'content' => '先生 '.$this->Auth->user('id').' は新しい授業を作成できる',
		            'type' => 'イベント'
				));
			} catch(Exception $e){
//				echo "<br>EXCEPTION<br>";
				//エラー発生時、データベースロールバック
				$this->Session->setFlash ( "エラーが発生ので、データベースにセーブできません。" );
				$dataSource->rollback();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_017',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '授業作成',
		            'content' => '先生 '.$this->Auth->user('id').' は新しい授業を作成できない',
		            'type' => 'エラー'
				));
			}
		}
	}
	
/*
	 * 授業リスト見る
	 */
	public function view_list_course(){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					) );
		}
		$this->loadModel('User');
		$this->loadModel('Course');
		
		//データベースクエリー
		$order = 'Course.created_date DESC';
		$fields = array (
				'Course.*',
				'User.username' 
				);

		$joins = array ();
		$joins [] = array (
			'table' => 'courses',
			'foreignKey' => false,
			'conditions' => array(
				'Course.teacher_id = Teacher.id'
			),
			'type' => 'INNER',
			'alias' => 'Course' 
			);
//		$joins [] = array (
//			'table' => 'users',
//			'foreignKey' => false,
//			'conditions' => 'User.id = Teacher.user_id',
//			'type' => 'INNER',
//			'alias' => 'User' 
//			);
		$group = 'Course.id';
		$limit = 5;
		$conditions = array (
			"User.id" => $this->Auth->user ( 'id' ),
			'Course.status' => 'active'
		);

		//paginate
		$this->paginate = compact ( 'order', 'fields', 'joins', 'conditions', 'group', 'limit' );
		//debug($this->paginate);
		
		//クエリー
		$data = $this->paginate ( "Teacher" );
		
		$this->set ( "data", $data );
	}
	
	// ロック、パスワードを覚えないする時、verify codeを入力
	public function confirm_verify_code($teacher_id){
		if($this->Session->check("User.username") || $this->Session->check(parent::TempLock)){
			$this->Teacher->unbindModel(array('hasMany' => array('Course')));
			$teacher = $this->Teacher->find('first', array(
					'conditions' => array(
					'Teacher.id' => $teacher_id
				)
			));	
			$this->set(compact("teacher"));
		
			if($this->request->is('post')){
				$data = $this->request->data;				
				$this->Teacher->set($data);
				
				if($this->Teacher->validates()){
					$this->Teacher->unbindModel(array('hasMany' => array('Course')));
					$teacher = $this->Teacher->find('first', array(
						'fields' => array('Teacher.*','User.*'),
						'conditions' => array(
							'Teacher.verify_code_answer' => $data['Teacher']['verify_code_answer'],
							'Teacher.verify_code' => $data['Teacher']['verify_code'],
							'Teacher.id' => $teacher_id
						)
					));
					unset($teacher['User']['primary_password']);
					
					if(!empty($teacher)){
						$usersController = new UsersController;
						// thay đổi trạng thái login_status thành ON
						$usersController->changeLoginStatusToOn($teacher);
						
						// update lại địa chỉ IP
						$this->Teacher->id = $teacher['Teacher']['id'];
						$this->Teacher->saveField('last_session_ip', $this->request->clientIp());					
						
						// xoa Session TEMPLOCK đi
						$this->Session->delete(parent::TempLock);
						
						// lưu $teacher vào trong Auth
						unset($teacher['Teacher']);
						$this->Auth->login($teacher['User']);
						
						// lưu Session User
						$this->Session->write("User.username",$teacher['User']['username']);
						$this->Session->write("User.id",$teacher['User']['id']);
						$this->Session->write("User.role",$teacher['User']['role']);
						$this->redirect(array('controller' => 'teachers', 'action' => 'index'));
					}
				}
			}
		}else{
			$this->redirect(array('controller' => 'home', 'action' => 'index'));
		}
	}
	
	// Su dung cho autocomplete de suggest tag
	public function key(){
	    $this->autoRender = false;
	    $this->loadModel("Tag");
	    
	    $keyword = $this->params['url']['term'];
	    
	    $codes = $this->Tag->find('all', array('conditions' => array('tag_name LIKE' => "%".$keyword."%")));	    
	    return new CakeResponse(array('body' => json_encode($codes)));
	}

	// show tất cả các course của giáo viên
	public function show_courses(){
		$this->set('title_for_layout', 'コースリストを表す');
		$this->loadModel('Course');
		$this->loadModel('User');
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller' => 'teachers', 'action' => 'login'));
		}
		
		$user_id = $this->Auth->user('id');
		
		$teacher = $this->User->find('first', array(
			'fields' => 'Teacher.id',
			'conditions' => array(
				'User.id' => $user_id
			)
		));
		
		$teacher_id = $teacher['Teacher']['id'];
		if($teacher_id){
			$courses = $this->Course->find('all',array('conditions' => array('Course.teacher_id' => $teacher_id)));
			if(!empty($courses)){
				$this->set(compact("courses"));
				$this->set("teacher_id",$this->Auth->user('id'));
				$this->set("teacher_name",$this->Auth->user('username'));
			}else{
				$this->Session->setFlash("そのコースが既存しない");
			}
		}else{
			$this->Session->setFlash("そのユーザ名が既存しない");
		}
	}
	
	// sửa thông tin của course
	public function edit_course($id = null){
		$this->set('title_for_layout', 'コース編集');
		$this->loadModel('Course');
		$this->loadModel('CourseTag');
		
		$this->set("id", $id);
		
		$this->Course->recursive = 1;
		$this->Course->unbindModel(array('hasMany' => array('Course', 'Document', 'Test', 'Course_Tag')));
		$this->Course->unbindModel(array('belongsTo' => array('Teacher')));
		$courses = $this->Course->find('all',array(
			'conditions' => array(
				'Course.id' => $id
			)
		));
		
		if(empty($courses)){
			$this->Session->setFlash("ユーザIDが既存しない");
			return $this->redirect(array('controller' => 'teachers', 'action' => 'view_a_course', $id));
		}else{
			$courses = $courses[0];
			$this->set(compact("courses"));
			
			if($this->request->is('Post')){
				$data = $this->request->data;
				
				$this->Course->set($data);
				if($this->Course->validates()){
					unset($data['tag']);
					$this->Course->id = $id;
					if($this->Course->save($data)){
						$this->Session->setFlash("成功なコース情報変更");
					}else{
						$this->Session->setFlash("失敗なコース情報変更");
					}
					return $this->redirect(array('controller' => 'teachers', 'action' => 'view_a_course', $id));
				}
			}	
		}
	}
	
/*
	 *授業削除
	 */
	public function delete_course($courseId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					) );
		}
		
		$this->loadModel("Course");
		$this->autoRender = false;
//		echo $courseId;
		//ログ
		$this->writeLog(array(
			'id' => 'LOG_018',
            'time' => time(),
            'actor' => $this->Auth->user ( 'id' ),
            'action' => '授業削除',
            'content' => '先生 '.$this->Auth->user('id').' は授業 '.$courseId.'を作成したい',
            'type' => 'オペレーション'
		));
		$dataSource = $this->Course->getDataSource();
		try{
			$dataSource->begin();
			//クェリー
			if(!$this->Course->delete($courseId,true)){
				throw new Exception();
			}
			$dataSource->commit();
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_019',
	            'time' => time(),
	            'actor' => 'システム',
	            'action' => '授業削除',
	            'content' => '先生 '.$this->Auth->user('id').' は授業 '.$courseId.'を作成できる',
	            'type' => 'イベント'
			));
		}catch(Exception $e){
			$this->Session->setFlash ( "データベースエラー：削除できません" );
			//データベースロールバック
			$dataSource->rollback();
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_020',
	            'time' => time(),
	            'actor' => 'システム',
	            'action' => '授業削除',
	            'content' => '先生 '.$this->Auth->user('id').' は授業 '.$courseId.'を作成できない',
	            'type' => 'エラー'
			));
		}
		$this->redirect(array(
			'controller' => "Teachers",
			'action' => 'view_list_course'
		));
	}
	
/*
	 * プロファイル変化
	 */
	public function change_profile(){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
					'controller' => 'users',
					'action' => 'login' 
					) );
		}
		$this->loadModel('User');
		//プロファイル情報とって
		$profile = $this->User->find('first',array(
			'conditions' => array('User.id' => $this->Auth->user('id'))
		));
		//		debug($profile);
		$this->set("data",$profile);
		
		//リクエスト処理
		if($this->request->is ('post') && !empty($this->data)){
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_006',
	            'time' => time(),
	            'actor' => $this->Auth->user('id'),
	            'action' => 'プロファイル変化',
	            'content' => '先生 '.$this->Auth->user('id').' は自分のプロファイル変化する',
	            'type' => 'オペレーション'
			));
			
			$tmp = $this->data;
			$tmp['User']['id'] = $this->Auth->user ( 'id' );
//			debug($tmp);
			$dataSource = $this->User->getDataSource();
			try{
				$dataSource->begin();
				//プロファイルセーブ
				if(!$this->User->save($tmp)){
					throw new Exception();
				}
				$dataSource->commit();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_007',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => 'プロファイル変化',
		            'content' => '先生 '.$this->Auth->user('id').' は自分のプロファイル変化できる',
		            'type' => 'イベント'
				));
			}catch(Exception $e){
				$this->Session->setFlash ( "データベースエラー：セーブできません" );
				//データベースロール
				$dataSource->rollback();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_008',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => 'プロファイル変化',
		            'content' => '先生 '.$this->Auth->user('id').' は自分のプロファイル変化できない',
		            'type' => 'エラー'
				));
			}
		}
	}

	/*
	 * パスワード変化
	 */
	public function change_password(){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
				'controller' => 'users',
				'action' => 'login' 
				) );
		}
		$data = array();
		//リクエスト処理
		if($this->request->is('post') && !empty($this->data)){
//			debug($this->data);
			$this->loadModel('User');
			$data['User']['id'] = $this->Auth->user('id');
			//パスワードハッシュ
			$data['User']['password'] = AuthComponent::password($this->Auth->user('username')."+".$this->data['Pass']['new_pass']."+"."t01");
//			echo $data['User']['password'];
//			debug($data);
//			var_dump($data);
			//データベースセーブ
			$dataSource = $this->User->getDataSource();
			try{
				$dataSource->begin();
				//パスワードセーブ
				$this->User->save($data);
				//データベースコミット
				$dataSource->commit();
			}catch(Exception $e){
				$this->Session->setFlash ( "データベースエラー：セーブできません" );
				//データベースロール
				$dataSource->rollback();
			}
		}
	}

	/*
	 * 秘密質問変化
	 */
	public function change_secret_question(){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
				'controller' => 'users',
				'action' => 'login' 
			) );
		}
		$this->loadModel('User');
		$this->loadModel('Teacher');
		//先生の情報
		$teacher = $this->Teacher->find("first",array(
			'condition' => array('user_id' => $this->Auth->user('id')),
		    'fields' => array('Teacher.id')
		));
//		debug($teacher);
		//リクエスト処理
		if($this->request->is('post') && !empty($this->data)){
//			debug($this->data);
			//セットデータ
			$teacher['Teacher']['verify_code'] = $this->data['SQ']['new_question'];
			$teacher['Teacher']['verify_code_answer'] = $this->data['SQ']['new_answer'];
//			debug($teacher);
			//データベースセーブ
			$dataSource = $this->Teacher->getDataSource();
			try{
				$dataSource->begin();
				//秘密質問セーブ
				if(!$this->Teacher->save($teacher)){
					throw new Exception();
				}
				//データベースコミット
				$dataSource->commit();
			}catch(Exception $e){
				$this->Session->setFlash ( "データベースエラー：セーブできません" );
				//データベースロールバック
				$dataSource->rollback();
			}
		}
	}
	
	/*
	 * 禁止学生
	 */
	public function ban_student(){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
				'controller' => 'users',
				'action' => 'login' 
			) );
		}
		
		//リクエスト処理
		if($this->request->is('post') && !empty($this->data)){
//			debug($this->data);
			
			$this->loadModel('Ban');
			$this->loadModel('Teacher');
			$this->loadModel('User');
			//先生の情報とって
			$teacher = $this->Teacher->find('first',array(
				'conditions' => array('user_id' => $this->Auth->user('id')),
		    	'fields' => array('Teacher.id')
			));
			
			if($teacher==null){
				$this->Session->setFlash('データベースエラー：あなたは先生ではありません。');
				return ;
			}
			//学生情報とって		
			$student = $this->User->find("first", array(
				'conditions' => array('username' => $this->data['Ban']['banStudent']),
				
			));
//			debug($student);
//			$student = $this->Student->find("first", array(
//				'conditions' => 'Student.name ='.$this->data['Ban']['banStudent']
//			));
			
			if($student==null){
				$this->Session->setFlash ("ユーザ名は存在しません" );
				return;
			} elseif($student['User']['role']!='student') {
				$this->Session->setFlash ("学生は存在しません" );
				return;
			}
			
			//セットデータ
			$ban['student_id'] = $student['Student']['id'];
			$ban['reason'] = $this->data['Ban']['banReason'];
			$ban['teacher_id'] = $teacher['Teacher']['id'];
			
			//存在禁止した学生チェック
			$existBan = $this->Ban->find('first', array(
				'conditions' => array(
					'student_id' => $ban['student_id'],
					'teacher_id' => $ban['teacher_id']
				)
			));
			if($existBan!=null){
				$this->Session->setFlash ("この学生は禁止されました。" );
				return;
			}
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_009',
	            'time' => time(),
	            'actor' => $this->Auth->user('id'),
	            'action' => '禁止学生',
	            'content' => '先生 '.$this->Auth->user('id').' は学生　'.$student['User']['id'].'を禁止する',
	            'type' => 'オペレーション'
			));
			
			//データベースセーブ
			$dataSource = $this->Ban->getDataSource();
			try{
				$dataSource->begin();
				//セールデータ
				if(!$this->Ban->save($ban)){
					throw new Exception();
				}
				//データベースコミット
				$dataSource->commit();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_010',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '禁止学生',
		            'content' => '先生 '.$this->Auth->user('id').' は学生　'.$student['User']['id'].'を禁止できる',
		            'type' => 'イベント'
				));
			}catch(Exception $e){
				$this->Session->setFlash ( "データベースエラー：セーブできません" );
				//データベースロールバック
				$dataSource->rollback();
				//ログ
				$this->writeLog(array(
					'id' => 'LOG_011',
		            'time' => time(),
		            'actor' => 'システム',
		            'action' => '禁止学生',
		            'content' => '先生 '.$this->Auth->user('id').' は学生　'.$student['User']['id'].'を禁止できない',
		            'type' => 'エラー'
				));
			}
		}
	}
	
	/*
	 * 禁止した学生リスト
	 */
	public function view_ban_list(){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
				'controller' => 'users',
				'action' => 'login' 
			) );
		}
		
		$this->loadModel('User');
		$this->loadModel('Ban');
		$this->loadModel('Teacher');
		//先生の情報とって
		$teacher = $this->Teacher->find('first',array(
				'conditions' => array('user_id' => $this->Auth->user('id')),
		    	'fields' => array('Teacher.id')
			));
			
		if($teacher==null){
			$this->Session->setFlash('データベースエラー：あなたは先生ではありません。');
			return ;
		}
		
		//禁止学生リスト
		$banData = $this->Ban->find('all', array(
			'conditions' => array(
				'teacher_id' => $teacher['Teacher']['id']
			)
		));
		
		for ($i=0;$i<count($banData);$i++){
			$result = $this->User->find('first', array(
				'conditions' => array(
					'Student.id' => $banData[$i]['Ban']['student_id']
				),
				'fields' => array(
					'username'
				)
			));
			$banData[$i]['Ban']['student_name'] = $result['User']['username']; 
		}
//		debug($banData);
		$this->set("data", $banData);
	}
	
	/*
	 * 禁止解除
	 */
	public function unban($banId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
				'controller' => 'users',
				'action' => 'login' 
			) );
		}
		$this->autoRender = false;
		
		$this->loadModel("Ban");
		$banData = $this->Ban->find('first', array(
			'conditions' => array(
				'id' => $banId
			)
		));
		if($banData==null){
			return;
		}
		//ログ
		$this->writeLog(array(
			'id' => 'LOG_012',
            'time' => time(),
            'actor' => $this->Auth->user ( 'id' ),
            'action' => '禁止解除',
            'content' => '先生 '.$this->Auth->user('id').' は学生　'.$banData['Ban']['student_id'].'　を禁止したい',
            'type' => 'オペレーション'
		));
		//データベースセーブ
		$dataSource = $this->Ban->getDataSource();
		try{
			$dataSource->begin();
			//禁止解除
			if(!$this->Ban->delete($banId)){
				throw new Exception();
			}
			$dataSource->commit();
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_013',
	            'time' => time(),
	            'actor' => 'システム',
	            'action' => '禁止解除',
	            'content' => '先生 '.$this->Auth->user('id').' は学生　'.$banData['Ban']['student_id'].'　を禁止できる',
	            'type' => 'イベント'
			));
		}catch(Exception $e){
			$this->Session->setFlash ( "データベースエラー：セーブできません" );
			//データベースロールバック
			$dataSource->rollback();
			//ログ
			$this->writeLog(array(
				'id' => 'LOG_014',
	            'time' => time(),
	            'actor' => $this->Auth->user ( 'id' ),
	            'action' => '禁止解除',
	            'content' => '先生 '.$this->Auth->user('id').' は学生　'.$banData['Ban']['student_id'].'　を禁止できない',
	            'type' => 'エラー'
			));
		}
		$this->redirect(array(
			'controller' => "Teachers",
			'action' => 'view_ban_list'
		));
	}
	
	/*
	 * 学生のテスト結果
	 */
	public function view_test_result($courseId){
		if (($this->Auth->user ( 'id' ) == null)) {
			$this->redirect ( array (
				'controller' => 'users',
				'action' => 'login' 
			) );
		}
		
		$this->loadModel('User');
		$this->loadModel('Course');
		$this->loadModel('Test');
		$this->loadModel('students_tests');
		//授業のテスト情報
		$test = $this->Test->find("all", array(
			'conditions' => array(
				'course_id' => $courseId
			)
		));
		//学生のテストけっか
		$doTest = array();
		for($i=0;$i<count($test);$i++){
			$doTest[] = $this->students_tests->find('all', array(
				'conditions' => array(
					'test_id' => $test[$i]['Test']['id']
				)
			));
			for($j=0;$j<count($doTest[$i]);$j++){
				$doTest[$i][$j]['test_name'] = $test[$i]['Test']['name'];
				$doTest[$i][$j]['student_name'] = $this->User->find('first',array(
					'conditions' => array(
						'Student.id' => $doTest[$i][$j]['students_tests']['student_id']
					) ,
					'fields' => array('User.username')
				));
			}
		}
		$this->set("data", $doTest);
	}
	
	
	// コースを見ること
	public function view_a_course($id = null){
		$this->set('title_for_layout', 'コースを見る');
		$this->set('course_id', $id);
		$this->loadModel('Course');
		$this->loadModel('Like');
		$this->loadModel('CourseTag');				
		
		// Courseテーブルからデータのquery
		$this->Course->recursive = 2;
		$courses = $this->Course->find('all',array(
			'conditions' => array(
				'Course.id' => $id
			)
		));
		
		if(!$courses){
			$this->Session->setFlash("コースIDが既存しない");
			return $this->redirect(array('action' => 'show_courses'));
		}
		
		$courses = $courses[0];
		
		// set id course
		$this->set("id", $id);
		$this->set(compact("courses"));
		
		// like course_countをとる
		$course_like_count = $this->Like->find('count', array(
			'conditions' => array(
				'Like.course_id' => $id
			)
		));
		$this->set(compact("course_like_count"));
		
		if($this->request->is('Post')){
			$data = $this->request->data;
			unset($data['tag']);
			$this->Course->id = $id;
			if($this->Course->save($data)){
				$this->Session->setFlash("成功な変更");				
			}else{
				$this->Session->setFlash("失敗な変更");
			}
			return $this->redirect(array('controller' => 'teachers', 'action' => 'view_course'));
		}
	}
	
	// 先生の登録
	public function register(){
		$this->set('title_for_layout', '先生の登録');
		$this->loadModel('User');
		$this->loadModel('Teacher');
		
		$validator = $this->User->validator();
		unset($validator['credit_number']['format_of_student']);
		
		if($this->request->is('post')){
			$this->User->set($this->request->data);
			
			if($this->User->validates()){
				// This method resets the model state for saving new information
				$this->User->create();
				
				// Formから送信したデータ
				$data  = $this->request->data;
				
				// パスワード暗号化のフォーマット : username + password + t01
				$data['User']['password'] = AuthComponent::password($data['User']['username']."+".$data['User']['password']."+t01");				
				
				if(!empty($data['User']['profile_img'])){
					$tmp_name_file_image = $data['User']['profile_img']['tmp_name'];
					$filename = $data['User']['username']."-".$this->data['User']['profile_img']['name'];
				}
				
				// data配列からre_password、checkboxを削除
				unset($data['User']['re_password']);
				unset($data['User']['checkbox']);
				
				// YYYY-mm-ddに誕生日を変化
				$birthday = $data['User']['birthday'];
				unset($data['User']['birthday']);
				$data['User']['birthday'] = $birthday['year']."-".$birthday['month']."-".$birthday['day'];
				
				$data["User"]["role"] = User::TEACHER;
				$data["User"]["active_status"] = User::INACTIVE;
				$data["User"]["login_status"] = User::OFF_LOGIN_STATUS;
				$data["User"]["primary_password"] = $data["User"]["password"];
				$data["User"]["last_active_time"] = date('Y-m-d H:i:s');

				// /img/Avatarのフォールダにプロファイルimgを保存
				if($filename!=""){
					$data['User']['profile_img'] = "/img/Avatar/". $filename;
					
					$path = WWW_ROOT.'img'.DS.'Avatar'.DS.$filename;
					if(!move_uploaded_file($tmp_name_file_image, $path)){
						$this->Session->setFlash("ファイルをアップロードできない");
						return FALSE;
					}
				}
				
				// 先生としてユーザを登録するのを実施
				$user = $this->User->save($data);
				if(!empty($user)){
					$this->request->data['Teacher']['user_id'] = $this->User->id;
					
					// add them 1 so thong tin vao trong mang Teacher trong data array
					$this->request->data['Teacher']['verify_code'] = $this->request->data['User']['verify_code'];
					$this->request->data['Teacher']['verify_code_answer'] = $this->request->data['User']['verify_code_answer'];
					$this->request->data['Teacher']['primary_verify_code_answer'] = $this->request->data['User']['verify_code_answer'];
					$this->request->data['Teacher']['additional_info'] = $this->request->data['User']['information'];
					$this->request->data['Teacher']['additional_info'] = $this->request->data['User']['information'];
					$this->request->data['Teacher']['last_session_ip'] = $this->request->clientIp();					
					
					$this->User->Teacher->save($this->request->data);
					$this->Session->setFlash(__("Register successful"));
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}else{
					$this->Session->setFlash(__("Unable to register"));
				}
			}
		}
	}
	
	/*
	// 先生のログイン
	public function login(){
		$this->loadModel('User');
		$this->set('title_for_layout', 'ログイン');
		if(!$this->Session->check("fail_login_count")){
			echo "Session : chua khoi tao";
		}else{
			echo "Session : ".$this->Session->read("fail_login_count");
		}
		
		// kiem tra xem Session đã tồn tại hay chua, nếu chưa thi redirect den index
		if($this->Auth->logIn()){
			return $this->redirect(array('controller' => 'teachers', 'action' => 'index'));
		}
		
		// Nếu mà chưa login thì cần login và lưu Session
		if ($this->request->is('post')) {
			$data = $this->request->data;
	        if($data){	        	
	        	$data['User']['password'] = AuthComponent::password($data['User']['username']."+".$data['User']['password']."+t01");
	        		        	
	        	// thực hiện kiểm tra username và password(đã mã hóa) trong CSDL, nếu mà ok thì
	        	// sẽ tự động lưu thông tin của user vào trong Session
	        	// hàm này mặc định là sẽ tìm trong bảng Users với 2 trường username, password
	        	// do đó mà ta cần phải cấu hình lại cái $components, cấu hình được đặt trong AppController
	        	
	        	$teacher = $this->User->find('first', array(
	        		'conditions' => array(
	        			'username' => $data['User']['username'],
	        			'password' => $data['User']['password'],
	        		)
	        	));
	        	
		        if (!empty($teacher)) {
		        	$this->Auth->login($teacher['User']);
	                $this->Session->setFlash("Login thanh cong");
	               	return $this->redirect(array('controller' => 'home', 'action' => 'index'));
	            }else{
	            	$this->Session->setFlash(__('Invalid username or password'));
	            }
	        }
        }
	}*/
	
	// ログアウト
	public function logout(){
		$this->Session->destroy ();
		$this->Auth->logout ();
		return $this->redirect ( array (
				'controller' => 'users',
				'action' => 'login'
		));
	}
}
?>
