<?php
class StudentCourseLearnsController extends  AppController {
	public $layout = 'admin';
	var $uses = array('StudentCourseLearn','User','Course', 'Student', 'Teacher', 'SystemParam');
	
	
	public function index(){
		echo "No data";
	}
	
	public function monthly_payment_student($student_id = null, $year = null, $month = null){
		$create_payment = false;
		$payments = null;
		$user_student = null;
		$user_teachers = null;
		
		$param = $this->SystemParam->findByName('KOMA_COST');
		if($param == null) $KOMA_COST = 20000;
		else $KOMA_COST = $param['SystemParam']['value'];
		
//		Check $year and $month
//		NOTE: Should get $system_start_date from SystemParam table
		if($year != 2013 && $year != 2014 && $year != 2015 && $year != 2016 && $year != 2017){
			throw new NotFoundException(__("Bad request"));
		}
		if($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && 
			$month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && 
			$month != 11 && $month != 12 ){
				throw new NotFoundException(__("Bad request"));
			}		
		
			
		//Check $student_id is exists?
		if($student_id == null){
			throw new NotFoundException(__("Bad request"));
		}
		$student = $this->Student->findById($student_id);
		//Check student exists?
		if($student == null){
			throw new NotFoundException(__("Bad request"));
		}
		$user_student = $this->User->findById($student['Student']['user_id']);
		//Check student in User table exists?
		if($user_student == null){
			throw new NotFoundException(__("Bad request"));
		}
		
//		$query_string = "SELECT * FROM students_courses_learn AS SC WHERE ;"; 
		$payments = $this->StudentCourseLearn->find('all', array('conditions' => array('student_id' => $student_id, 'buy_date LIKE' => "%$year-$month%")));
		//Check there are no payment for this student
		if(count($payments) == 0){
			$this->Session->setFlash("There are no payment for this student in this month");
		}
		else{
			$i = 0;
			foreach ($payments as $payment){
				$user_students[$i] = $this->User->findById($payment['Student']['user_id']);
				$teacher_id = $payment['Course']['teacher_id'];
				$teacher = $this->Teacher->findById($teacher_id);
				$user_teachers[$i] = $this->User->findById($teacher['Teacher']['user_id']);
				$i ++;
			}
			
//			debug($payments);
			$current_year = date('Y', time());
			$current_month = date('m', time());
			$current_date = date('d', time());
			if($current_date >= 1 && $current_date <=10){
				if(($current_year * 12 + $current_month - 1) == ($year *12 + $month)) $create_payment = true;
			}
		}
		

		$this->set("KOMA_COST", $KOMA_COST);
		$this->set("create_payment", $create_payment);
		$this->set("teachers",$user_teachers );
		$this->set("student",$user_student );
		$this->set("payments", $payments);
	}
	
public function monthly_payment_teacher($teacher_id = null, $year = null, $month = null){
		$create_payment = false;
		$payments = null;
		$user_students = null;
		$user_teacher = null;
		$param = $this->SystemParam->findByName('KOMA_COST');
		if($param == null) $KOMA_COST = 20000;
		else $KOMA_COST = $param['SystemParam']['value'];
		
//		Check $year and $month
//		NOTE: Should get $system_start_date from SystemParam table
		if($year != 2013 && $year != 2014 && $year != 2015 && $year != 2016 && $year != 2017){
			throw new NotFoundException(__("Bad request"));
		}
		if($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && 
			$month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && 
			$month != 11 && $month != 12 ){
				throw new NotFoundException(__("Bad request"));
			}		
		
			
		//Check $teacher_id is exists?
		if($teacher_id == null){
			throw new NotFoundException(__("Bad request"));
		}
		$teacher = $this->Teacher->findById($teacher_id);
		//Check teacher exists?
		if($teacher == null){
			throw new NotFoundException(__("Bad request"));
		}
		$user_teacher = $this->User->findById($teacher['Teacher']['user_id']);
		//Check teacher in User table exists?
		if($user_teacher == null){
			throw new NotFoundException(__("Bad request"));
		}
		
//		Find all course of teacher
//		$teacher_courses = $this->Teacher->Course->findById($teacher_id);
//		$teacher_courses = $this->Course->Teacher->findById($teacher_id);
//		$teacher_courses = $this->Course->Teacher->find('all', array('conditions' => array('Teacher.id' => $teacher_id)));
//		$teacher_courses = $this->Teacher->Course->find('all', array('conditions' => array('Course.teacher_id' => $teacher_id), 'fields' => 'Course.id'));
//		debug($teacher_courses);
//		die();
		
		
//		$query_string = "SELECT * FROM students_courses_learn AS SC WHERE ;"; 
		$payments = $this->StudentCourseLearn->find('all', array('conditions' => array('Course.teacher_id' => $teacher_id, 'buy_date LIKE' => "%$year-$month%")));
//		debug($payments);
//		die();
		//Check there are no payment for this student
		if(count($payments) == 0){
			$this->Session->setFlash("There are no payment for this teacher in this month");
		}
		else{
			
			$i = 0;
			foreach ($payments as $payment){
				$student_id = $payment['StudentCourseLearn']['student_id'];
				$student = $this->Student->findById($student_id);
				$user_students[$i] = $this->User->findById($student['Student']['user_id']);
				$i ++;
			}
			
			$current_year = date('Y', time());
			$current_month = date('m', time());
			$current_date = date('d', time());
			if($current_date >= 1 && $current_date <=10){
				if(($current_year * 12 + $current_month - 1) == ($year *12 + $month)) $create_payment = true;
			}
		}
		
		$this->set("KOMA_COST", $KOMA_COST);
		$this->set("create_payment", $create_payment);
		$this->set("teacher",$user_teacher );
		$this->set("students",$user_students );
		$this->set("payments", $payments);
	}
	
public function monthly_payment_system($year = null, $month = null){
		$create_payment = false;
		$payments = null;
		$user_students = null;
		$user_teachers = null;
		$param = $this->SystemParam->findByName('KOMA_COST');
		if($param == null) $KOMA_COST = 20000;
		else $KOMA_COST = $param['SystemParam']['value'];
		
//		Check $year and $month
//		NOTE: Should get $system_start_date from SystemParam table
		if($year != 2013 && $year != 2014 && $year != 2015 && $year != 2016 && $year != 2017){
			throw new NotFoundException(__("Bad request"));
		}
		if($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && 
			$month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && 
			$month != 11 && $month != 12 ){
				throw new NotFoundException(__("Bad request"));
			}		
		
		$payments = $this->StudentCourseLearn->find('all', array('conditions' => array('buy_date LIKE' => "%$year-$month%")));
//		debug($payments);
//		die();
		//Check there are no payment for this student
		if(count($payments) == 0){
			$this->Session->setFlash("There are no payment this month");
		}
		else{
			
			$i = 0;
			foreach ($payments as $payment){
				$user_students[$i] = $this->User->findById($payment['Student']['user_id']);
				$teacher_id = $payment['Course']['teacher_id'];
				$teacher = $this->Teacher->findById($teacher_id);
				$user_teachers[$i] = $this->User->findById($teacher['Teacher']['user_id']);
				$i ++;
			}
			
			$current_year = date('Y', time());
			$current_month = date('m', time());
			$current_date = date('d', time());
			if($current_date >= 1 && $current_date <=10){
				if(($current_year * 12 + $current_month - 1) == ($year *12 + $month)) $create_payment = true;
			}
		}
		
		
		$this->set('year', $year);
		$this->set('month', $month);
		$this->set("KOMA_COST", $KOMA_COST);
		$this->set("create_payment", $create_payment);
		$this->set("teachers",$user_teachers );
		$this->set("students",$user_students );
		$this->set("payments", $payments);
	}
	
	public  function view_payment_file_list($message = null){
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		$payment_folder_path = "files/payments";
		
		$payment_folder = new Folder($payment_folder_path);
//		debug($payment_folder);
		$files = $payment_folder->read();
		if(count($files[1]) == 0) $this->set('message', 'There are no payment file now');
		else{
			$i = 0;
			foreach ($files[1] as $file_name) {
				$file[$i] = new File ($payment_folder_path.DS.$file_name);
//				echo $file[$i]->lastAccess();
//				debug($file[$i]);
				$i ++;
			}
			$this->set('files', $file);
		}
//		die();
	}
	
	public function create_payment($year = null, $month = null){
		$current_user = $this->Auth->user();
//		debug($current_user);
//		die();
		$param = $this->SystemParam->findByName('KOMA_COST');
		if($param == null) $KOMA_COST = 20000;
		else $KOMA_COST = $param['SystemParam']['value'];
		
//		Check $year and $month
//		NOTE: Should get $system_start_date from SystemParam table
		if($this->_check_month($year, $month) == false){
			throw new NotFoundException(__("Bad request"));
		}		
		
		if($this->_check_create_payment_option($year, $month) == false){
			throw new NotFoundException(__("Bad request"));
		}
		
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		$payment_folder_path = "files/payments";
		$monthly_payment_file_name = "ELS-UBT-$year-$month.tsv";
		
		$payment_folder = new Folder($payment_folder_path, true, 0777);
		$monthly_payment_file = new File($payment_folder->path. DS .$monthly_payment_file_name);
//		echo "<br>----" .file_exists($monthly_payment_file->path);
//		Neu khong ton tai thi file_exists tra ve null
//		Neu file ton tai thi tra ve 1		
		if (file_exists($monthly_payment_file->path) == null){
			$monthly_payment_file->create();
			
			$write_string = "ELS-UBT-GWK54M78" . "\t"
							.$year . "\t"
							.$month . "\t"
							.date('Y', time()) . "\t"
							.date('m', time()) . "\t"
							.date('d', time()) . "\t"
							.date('H', time()) . "\t"
							.date('i', time()) . "\t"
							.date('s', time()) . "\t"
							.$current_user['User']['username']. "\t"
							.$current_user['User']['full_name'] . "\n";
			
			$monthly_payment_file->append($write_string);
//			Student create
			$students =  $this->StudentCourseLearn->find('all',
								array('conditions' => array('buy_date LIKE' => "%$year-$month%"),
									'group' => 'student_id'));
		
			foreach($students as $student){
				$user_student = $this->User->findById($student['Student']['user_id']);
				$write_string = $user_student['User']['username']. "\t"
								. $user_student['User']['full_name'] . "\t" 
								. $this->_count_payment_student($student['StudentCourseLearn']['student_id'], $year, $month)*$KOMA_COST . "\t"
								. $user_student['User']['address'] . "\t"
								. $user_student['User']['phone'] . "\t"
								. "18" . "\t"
								. $user_student['User']['credit_card'] . "\n";
//				echo $user_student['User']['username'] . $this->_count_payment_student($student['StudentCourseLearn']['student_id'], $year, $month) . '<br>';
				$monthly_payment_file->append($write_string);
			}
			//		Teacher create
			$teachers =  $this->StudentCourseLearn->find('all',
								array('conditions' => array('StudentCourseLearn.buy_date LIKE' => "%$year-$month%"),
										'group' => 'teacher_id'));
			foreach($teachers as $teacher){
				$tmp = $this->Teacher->findById($teacher['Course']['teacher_id']);
				$user_teacher = $this->User->findById($tmp['Teacher']['user_id']);
				$write_string = $user_teacher['User']['username']. "\t"
								. $user_teacher['User']['full_name'] . "\t" 
								. $this->_count_payment_teacher($teacher['Course']['teacher_id'], $year, $month) * $KOMA_COST . "\t"
								. $user_teacher['User']['address'] . "\t"
								. $user_teacher['User']['phone'] . "\t"
								. "52" . "\t"
								. $user_teacher['User']['credit_card'] . "\n";
//				echo $user_teacher['User']['username'] . $this->_count_payment_teacher($teacher['Course']['teacher_id'], $year, $month) . '<br>';
				$monthly_payment_file->append($write_string);
			}
			
			$write_string = "END___END___END\t$year\t$month";
			$monthly_payment_file->append($write_string);
			$monthly_payment_file->close();
			
//			debug($monthly_payment_file);
//			die();
						
			$this->set("message","This month payment file created successfully!");
		}
		else{
			$this->set("message","This month payment file exists!");
		}
//		$this->redirect(array('action' => 'view_payment_file_list'));
////		Student create
//		$students =  $this->StudentCourseLearn->find('all',
//								array('conditions' => array('buy_date LIKE' => "%$year-$month%"),
//									'group' => 'student_id'));
//		
//
//		foreach($students as $student){
//			$user_student = $this->User->findById($student['Student']['user_id']);
//			echo $user_student['User']['username'] . $this->_count_payment_student($student['StudentCourseLearn']['student_id'], $year, $month) . '<br>';
//		}
//		debug($students);
//		die();
		
////		Teacher create
//		$teachers =  $this->StudentCourseLearn->find('all',
//								array('conditions' => array('StudentCourseLearn.buy_date LIKE' => "%$year-$month%"),
//									'group' => 'teacher_id'));
//		foreach($teachers as $teacher){
//			$tmp = $this->Teacher->findById($teacher['Course']['teacher_id']);
//			$user_teacher = $this->User->findById($tmp['Teacher']['user_id']);
//			echo $user_teacher['User']['username'] . $this->_count_payment_teacher($teacher['Course']['teacher_id'], $year, $month) . '<br>';
//		}
		
	}
	
	public function download_payment_file($file_ext = null, $file_name = null){
		return $this->_download_payment_file($file_ext, $file_name);
//		return $this->response->file('index.php');
	}
	
	protected  function _count_payment_student($student_id = null, $year = null, $month = null){
		$count_payment = 0;
		$count_payment = $this->StudentCourseLearn->find('count',
								array('conditions' => array('student_id'=>$student_id,'buy_date LIKE' => "%$year-$month%"),
									'fields'=>array('DISTINCT StudentCourseLearn.student_id')));
		return $count_payment;
	}
	
	protected  function _count_payment_teacher($teacher_id = null, $year = null, $month = null){
		$count_payment = 0;
		$count_payment = $this->StudentCourseLearn->find('count',
								array('conditions' => array('Course.teacher_id' => $teacher_id, 'buy_date LIKE' => "%$year-$month%"),
									'fields' => array('DISTINCT Course.teacher_id')));
		
		return $count_payment;
	}
	
	protected function _check_month($year = null, $month = null){
		$check_month = true;
		if($year != 2013 && $year != 2014 && $year != 2015 && $year != 2016 && $year != 2017){
			$check_month = false;
		}
		if($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && 
			$month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && 
			$month != 11 && $month != 12 ){
			$check_month = false;
		}
		return $check_month;
	}
	
	protected function _check_create_payment_option($year = null, $month = null){
		$create_payment_option = false; 
		$current_year = date('Y', time());
		$current_month = date('m', time());
		$current_date = date('d', time());
		if($current_date >= 1 && $current_date <=10){
			if(($current_year * 12 + $current_month - 1) == ($year *12 + $month)) $create_payment_option = true;
		}
		
		return $create_payment_option;
	}
	
	protected function _check_payment_file($year = null, $month = null){
		$system_payment_folder;
		return true;
	}
	
	protected function _download_payment_file($file_ext = null, $file_name = null){
		$payment_folder_path = "webroot/files/payments";
//		$this->response->file($payment_folder_path, array('download' => true,
//        			'name' => $file_name,
//					'extension' => $file_ext,));
		$this->response->file($payment_folder_path.DS.$file_name.'.'.$file_ext);
    	return $this->response;
	}
}
	
	
