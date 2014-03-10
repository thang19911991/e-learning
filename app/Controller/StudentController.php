<?php
CakePlugin::load ( 'Uploader' );
App::import ( 'Vendor', 'Uploader.Uploader' );
App::uses ( 'DboSource', 'Model/Datasource' );
App::uses ( 'CakeEmail', 'Network/Email' );
function uploaderFilename($name, $field, $data) {
	return $name;
}
?>
<?php

class StudentController extends AppController {
	public $layout = 'student';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('std_register','login');
	}
	
	function std_register() {
		$this->layout = 'default';
		$this->set ( 'title_for_layout', '学生の登録ページ' );
		if (! empty ( $this->data )) {
			$this->loadModel ( 'User' );
			$this->loadModel ( 'Student' );
			$this->User->set ( $this->request->data );
			// debug($this->User->validates());
			if (! $this->User->validates ()) {
				unset ( $this->request->data ['Submit'] );
			} else {
				$data = $this->request->data;
				$files = $this->request->data ['User'] ['profile_img'];
				$images = $files ['name'];
				if (! empty ( $files )) {
					$data ['User'] ['profile_img'] = $data ['User'] ['username'] . '-' . $images;
					$imageName = $data ['User'] ['profile_img'];
					move_uploaded_file ( $files ['tmp_name'], WWW_ROOT . 'img' . DS . 'Avatar' . DS . $imageName );
				} else {
					$data ['User'] ['profile_img'] = 'Avatar.jpg';
				}
				$data ['User'] ['active_status'] = 'inactive';
				$data ['User'] ['role'] = 'student';
				$data ['Student'] ['addtional_info'] = ' ';
				$data ['User'] ['password'] = AuthComponent::password ( $this->Auth->user ( 'username' ) . '+' . $data ['User'] ['password'] . "+t01" );
				$this->User->create ();
				$this->User->saveAll ( $data );
				$this->Session->setFlash ( '君のユーザは登録しました。管理者は教科しなければならないので、お待ちしてください！' );
				$this->redirect ( array (
						'controller' => 'student',
						'action' => 'std_login' 
				) );
			}
		}
	}
	public function std_login() {
		$this->layout = 'default';
		$this->set ( 'title_for_layout', '学生のログインページ' );
		if (! $this->Session->check ( "fail_login_count" )) {
			// echo "Session : chua khoi tao";
		} else {
			echo "Session : " . $this->Session->read ( "fail_login_count" );
		}
		if ($this->Auth->logIn ()) {
			return $this->redirect ( array (
					'controller' => 'student',
					'action' => 'std_index' 
			) );
		}
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			if ($data) {
				$data ['User'] ['password'] = AuthComponent::password ( $data ['User'] ['password'] );
				
				if ($this->Auth->login ()) {
					$this->Session->write ( "fail_login_count", "login thanh cong" );
					$this->Session->setFlash ( "Login thanh cong" );
				} else {
					$this->Session->write ( "fail_login_count", "login khong thanh cong" );
					$this->Session->setFlash ( __ ( '' ) );
				}
			}
		}
	}
	
	public function std_view_document($id = null) {
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		
		$this->loadModel ( "Document" );
		$this->loadModel ( "StudentDocumentReport" );
		
		$documents = $this->Document->find ( 'first', array (
				'conditions' => array (
						'Document.id' => $id 
				) 
		) );
		
		$reports = $this->StudentDocumentReport->find ( 'all', array (
				'conditions' => array (
						'StudentDocumentReport.document_id' => $id 
				) 
		) );
		
		$student_id = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		$student_id = $student_id ['Student'] ['id'];
		$this->set ( "student_id", $student_id );
		$this->set ( compact ( "reports" ) );
		$this->set ( compact ( "documents" ) );
		
		
		
		
	}
	
	public function std_like() {
		$this->autoRender = false;
		$this->loadModel ( "Like" );
		$student_id = $_POST ['student_id'];
		$course_id = $_POST ['course_id'];
		$sql = "INSERT INTO `e_learning`.`likes` (`student_id`, `course_id`) VALUES ('" . $student_id . "', '" . $course_id . "')";
		$this->Like->query ( $sql );
		return new CakeResponse ( array (
				'body' => 'ok' 
		) );
	}
	
	public function std_course_report() {
		$this->autoRender = false;
		$this->loadModel ( "StudentCourseReport" );
		$student_id = $_POST ['student_id'];
		$course_id = $_POST ['course_id'];
		$content = $_POST ['content'];
		$sql = "INSERT INTO `e_learning`.`students_courses_report` (`student_id`, `course_id`,`content`) VALUES ('" . $student_id . "', '" . $course_id . "', '" . $content . "')";
		$this->StudentCourseReport->query ( $sql );
		return new CakeResponse ( array (
				'body' => 'ok' 
		) );
	}
	public function std_document_report() {
		$this->autoRender = false;
		$this->loadModel ( "StudentDocumentReport" );
		$student_id = $_POST ['student_id'];
		$document_id = $_POST ['document_id'];
		$content = $_POST ['content'];
		echo $content;
		$sql = "INSERT INTO `e_learning`.`students_documents_report` (`student_id`, `document_id`,`content`) VALUES ('" . $student_id . "', '" . $document_id . "', '" . $content . "')";
		$this->StudentDocumentReport->query ( $sql );
		return new CakeResponse ( array (
				'body' => 'ok' 
		) );
	}
	public function std_detail_course($id = null) {
		
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		
		$this->loadModel ( "Like" );
		$this->loadModel ( "User" );
		$this->loadModel ( "StudentCourseReport" );
		
		$this->set ( 'title_for_layout', 'コースを見る' );
		$this->loadModel ( 'Course' );
		$this->loadModel ( 'CourseTag' );
		$this->Course->recursive = 2;
		$courses = $this->Course->find ( 'all', array (
				'conditions' => array (
						'Course.id' => $id 
				) 
		) );
		
		if (! $courses) {
			$this->Session->setFlash ( "id khong ton tai" );
			return $this->redirect ( array (
					'action' => 'std_list_course' 
			) );
		}
		
		$likes = $this->Like->find ( 'all', array (
				'conditions' => array (
						'Like.course_id' => $id 
				) 
		) );
		
		$reports = $this->StudentCourseReport->find ( 'all', array (
				'conditions' => array (
						'StudentCourseReport.course_id' => $id 
				) 
		) );
		
		$id = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		$id = $id ['Student'] ['id'];
		$this->set ( "id", $id );
		
		$this->set ( compact ( "likes" ) );
		$this->set ( compact ( "courses" ) );
		$this->set ( compact ( "reports" ) );
	}
	public function std_try_course($id = null) {
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		));
		$this->set ( compact ( 'user' ) );
		
		$this->set ( 'title_for_layout', 'コースを見る' );
		$this->loadModel ( 'Course' );
		$this->loadModel ( 'CourseTag' );
		$this->Course->recursive = 2;
		$courses = $this->Course->find ( 'all', array (
				'conditions' => array (
						'Course.id' => $id 
				) 
		) );
		if (! $courses) {
			$this->Session->setFlash ( "id khong ton tai" );
			return $this->redirect ( array (
					'action' => 'std_list_course' 
			) );
		}
		$this->set ( "id", $id );
		$this->set ( compact ( "courses" ) );
	}
	function std_change_pass() {
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		/* check passs */
		if (! empty ( $this->request->data )) {
			if (empty ( $this->request->data ['password1'] )) {
				$this->Session->setFlash ( '新しいパスワードはまだ入力しない！' );
			} else if ($this->Auth->password ( $this->request->data ['password'] ) == $user ['User'] ['password']) {
				if ($this->request->data ['password1'] == $this->request->data ['password2']) {
					if ($this->request->data ['password1'] != $this->request->data ['password']) {
						$savedata ['User'] ['password'] = $this->data ['password1'];
						// $savedata['User']['full_name'] = 'abcx';
						// echo '<pre>';
						// var_dump($savedata);
						// die();
						$this->User->id = $this->Auth->user ( 'id' );
						$this->User->save ( $savedata );
						$this->Session->setFlash ( 'パスワードは変更しました！' );
						$this->redirect ( array (
								'controller' => 'student',
								'action' => 'std_logout' 
						) );
					} else {
						$this->Session->setFlash ( 'Enter difference passwords.' );
					}
				} else {
					$this->Session->setFlash ( '新しいパスワードは違います！' );
				}
			} else {
				$this->Session->setFlash ( '古いパスワードは正しくない！' );
			}
		} else {
			$this->Session->setFlash ( '全部テキストボックスに入力してください。' );
		}
	}
	
	public function std_profile() {
		$this->loadModel ( 'User' );
		$this->set ( 'title_for_layout', '学生のプロファイルページ' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'full_name',
						'username',
						'email',
						'phone',
						'credit_number',
						'profile_img',
						'address' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
	}
	public function std_test_result() {
		$this->set ( 'title_for_layout', '学生のテスト結果ページ' );
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		/* test-result */
		$this->loadModel ( 'StudentTest' );
		$this->loadModel ( 'Test' );
		$this->loadModel ( 'User');
		$id = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		$id = $id ['Student'] ['id'];
		$test = $this->StudentTest->find ( 'first', array (
				'conditions' => array (
						'StudentTest.student_id' => $id 
				),
				'fields' => array (
						'id',
						'test_id',
						'point',
						'test_date' 
				) 
		) );
		$test_name = $this->Test->find ('first',array(
			'conditions' =>array( 'Test.test_id' => $test['StudentTest']['test_id']),
			'fields' => 'name'	
		));
		
		$this->set ( compact ( 'test' ) );
		$this->set ( compact ( 'test_name' ) );
	}
	public function std_index() {
		$this->set ( 'title_for_layout', '学生のホームページ' );
		// $this->loadModel('Students_courses_learn');
		$this->loadModel ( 'StudentCourseLearn' );
		$this->loadModel ( 'Course' );
		$this->loadModel ( 'User' );
		// debug($this->Auth->user());die();
		// $course = $this->StudentCourseLearn->find('first',array(
		// 'conditions' => array('StudentCourseLearn.student_id'=> AuthComponent::user('id')),
		// 'fields' => array('course_id','end_date','buy_date'),
		// ));
		// $course_name = $this->Course->find('first',array(
		// 'conditions' => array('Course.course_id'=> $course['StudentCourseLearn']['course_id']),
		// 'fields' => array('course_name'),
		// ));
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'full_name' 
				) 
		) );
		// debug($user);die;
		$this->set ( compact ( 'user' ) );
	}
	public function std_edit() {
		$id = AuthComponent::user ( 'id' );
		$this->loadModel ( "User" );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'full_name',
						'username',
						'birthday',
						'email',
						'credit_number',
						'phone',
						'address',
						'profile_img' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		if ($this->request->is ( 'Post' )) {
			$this->User->set ( $this->request->data );
			// debug($this->User->validates());
			if (! $this->User->validates ()) {
				unset ( $this->request->data ['Submit'] );
			} else {
				$data = $this->request->data;
				$files = $this->request->data ['User'] ['profile_img'];
				$images = $files ['name'];
				// debug($files);die;
				if (! empty ( $images )) {
					$data ['User'] ['profile_img'] = $user ['User'] ['username'] . '-' . $images;
					$imageName = $data ['User'] ['profile_img'];
					move_uploaded_file ( $files ['tmp_name'], WWW_ROOT . 'img' . DS . 'Avatar' . DS . $imageName );
				} else {
					$data ['User'] ['profile_img'] = $user ['User'] ['profile_img'];
				}
				// debug($data);die;
				$data ['User'] ['id'] = AuthComponent::user ( 'id' );
				$this->User->save ( $data, false );
				$this->Session->setFlash ( '君のプロフィールは変更しました！' );
				$this->redirect ( array (
						'controller' => 'student',
						'action' => 'std_login' 
				) );
			}
		}
	}
	public function std_deactive() {
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		
		$validator = $this->User->validator ();
		if ($this->request->is ( 'post' )) {
			$this->User->set ( $this->data );
			if ($this->User->validates ()) {
				
				$data = $this->request->data;
				$data ['User'] ['password'] = AuthComponent::password ( $this->Auth->user ( 'username' ) . '+' . $data ['User'] ['password'] . "+t01" );
				
				$user_check = $this->User->find ( 'first', array (
						'conditions' => array (
								'User.username' => $this->Auth->user ( 'username' ),
								'User.password' => $data ['User'] ['password'] 
						) 
				) );
				
				if (empty ( $user_check )) {
					$this->Session->setFlash ( "パスワードが間違い。" );
					return;
				} else {
					$sql = "UPDATE `e_learning`.`users` SET `active_status`='inactive' WHERE `id`=" . $this->Auth->user ( 'id' );
					$this->User->query ( $sql );
					return $this->redirect ( array (
							'controller' => 'users',
							'action' => 'std_login' 
					) );
				}
			}
		}
	}
	public function std_search() {
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		/* search */
		$this->loadModel ( "Teacher" );
		$this->loadModel ( "Course" );
		$this->loadModel ( "Tag" );
		$results = "";
		$results_course = "";
		$results_tag = "";
		if ($this->request->is ( 'post' )) {
			
			$data = $this->request->data;
			$type = $data ['User'] ['type'];
			$keyword = $data ['User'] ['keyword'];
			
			if ($keyword == "") {
				
				return $this->redirect ( array (
						'controller' => 'student',
						'action' => 'std_search' 
				) );
			} else {
				
				// Tim Kiem Theo Ten Giao Vien
				if ($type == 1) {
					$results = $this->User->find ( 'all', array (
							'conditions' => array (
									'OR' => array (
											'User.username LIKE' => "%" . $keyword . "%",
											'User.full_name LIKE' => "%" . $keyword . "%" 
									) 
							) 
					)
					 );
				} else if ($type == 2) {
					// Tim Kiem Theo Bai Giang
					
					$results_course = $this->Course->find ( 'all', array (
							'conditions' => array (
									'OR' => array (
											'Course.course_name LIKE' => "%" . $keyword . "%",
											'Course.description LIKE' => "%" . $keyword . "%" 
									) 
							) 
					) );
				} else {
					// Tim kiem theo tag
					$results_tag = $this->Tag->find ( 'all', array (
							'conditions' => array (
									"Tag.tag_name LIKE " => "%" . $keyword . "%" 
							) 
					) );
				}
			}
		}
		$this->set ( compact ( "results" ) );
		$this->set ( compact ( "results_course" ) );
		$this->set ( compact ( "results_tag" ) );
	}
	public function std_list_course() {
		/* load profile_img */
		$this->loadModel ( 'User' );
		$user = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => AuthComponent::user ( 'id' ) 
				),
				'fields' => array (
						'id',
						'profile_img',
						'password' 
				) 
		) );
		$this->set ( compact ( 'user' ) );
		$this->loadModel ( "Course" );
		$this->loadModel ( "StudentCourseLearn" );
		$this->loadModel ( "StudentCourseBan" );
		$this->loadModel ( "Ban" );
		
		$id = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		$id = $id ['Student'] ['id'];
		$sql_learn = "SELECT * FROM students_courses_learn,courses  WHERE students_courses_learn.course_id = courses.id  AND student_id=$id";
		$course_learn = $this->StudentCourseLearn->query ( $sql_learn );
		
		$sql_ban = "SELECT * FROM students_courses_ban  WHERE student_id=" . $id;
		$course_ban = $this->StudentCourseBan->query ( $sql_ban );
		
		$this->set ( compact ( "course_learn" ) );
		$this->set ( compact ( "course_ban" ) );
		$sql_teacher_ban = "SELECT * FROM bans WHERE student_id=" . $id;
		$teacher_ban = $this->Ban->query ( $sql_teacher_ban );
		$this->set ( compact ( "teacher_ban" ) );
		// Goi y khoa hoc
		$sql_recomment = "SELECT * FROM courses WHERE courses.id NOT IN (SELECT students_courses_learn.course_id FROM students_courses_learn WHERE student_id=$id)";
		$course_recomment = $this->Course->query ( $sql_recomment );
		$this->set ( compact ( "course_recomment" ) );
	}
	public function std_buy($id = null) {
		$this->autoRender = false;
		$this->loadModel ( "User" );
		$student_id = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		$student_id = $student_id ['Student'] ['id'];
		$this->loadModel ( "StudentCourseLearn" );
		$end_date = date ( 'Y-m-d', time () + 604800 );
		$sql = "INSERT INTO `e_learning`.`students_courses_learn` (`student_id`, `course_id`, `buy_date`, `status`, `end_date`) VALUES ('" . $student_id . "', '" . $id . "', '" . date ( "Y-m-d" ) . "', 'learning'
						,'" . $end_date . "'
						)
             		";
		$this->StudentCourseLearn->query ( $sql );
		return $this->redirect ( array (
				'controller' => 'student',
				'action' => 'std_detail_course',
				$id 
		) );
	}
	
	public function std_logout() {
		$this->Session->destroy ();
		$this->Auth->logout ();
		return $this->redirect ( array (
				'controller' => 'student',
				'action' => 'std_login'
		));
	}
}
?>
