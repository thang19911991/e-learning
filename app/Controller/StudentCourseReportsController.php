<?php
class StudentCourseReportsController extends  AppController {
	public $layout = 'admin';
	var $uses = array('StudentCourseReport','User','Course', 'Student', 'Teacher');
	
	public function index(){
		$this->redirect(array("controller" => "student_course_reports", "action" => "list_report"));
	}
	
	public function list_report(){
		$reports = $this->StudentCourseReport->find('all');
		$i = 0;
		if(count($reports) == 0) {
			throw new NotFoundException(__('There are no course report'));
		}
//		echo count($reports);
		foreach ($reports as $report){
//			debug($report);
			$teacher_id = $report['Course']['teacher_id'];
			$teacher = $this->Teacher->findById($teacher_id);
			$user_teacher[$i] = $this->User->findById($teacher['Teacher']['user_id']);
			
			$user_student[$i] = $this->User->findById($report['Student']['user_id']);
			$i++;
		}
		$this->set('students', $user_student);
		$this->set('teachers', $user_teacher);
		$this->set('reports', $this->StudentCourseReport->find('all'));
	}
	
	public function list_report_of_course($course_id = null){
		if (!$course_id) {
			throw new NotFoundException(__('Invalid course'));
		}
		$reports = $this->StudentCourseReport->find('all', array('conditions' => array('course_id' => $course_id)));
		if (!$reports) {
			throw new NotFoundException(__('No copyright report about this course'));
		}
		if(count($reports) == 0) {
			throw new NotFoundException(__('There are no course copyright report'));
		}
//		echo '<pre>';
//		var_dump($course_id);
//		var_dump($reports);
//		die();
		$course = $this->Course->findById($course_id);
		$teacher = $this->Teacher->findById($course['Course']['teacher_id']);
		$user_teacher = $this->User->findById($teacher['Teacher']['user_id']);
		
		$i = 0;
		foreach ($reports as $report){
//			debug($report);
			$user_student[$i] = $this->User->findById($report['Student']['user_id']);
			$i++;
		}
		
		$this->set('students', $user_student);
		$this->set('teacher', $user_teacher);
		$this->set('reports', $reports);
	}
	
	public function view_a_report($id = null){
		if (!$id) {
			throw new NotFoundException(__('Invalid report'));
		}
		$report = $this->StudentCourseReport->findById($id);
		if (!$report) {
			throw new NotFoundException(__('Invalid report'));
		}
		$teacher_id = $report['Course']['teacher_id'];
		$teacher = $this->Teacher->findById($teacher_id);
		$user_teacher = $this->User->findById($teacher['Teacher']['user_id']);
		
		$user_student = $this->User->findById($report['Student']['user_id']);
		
		$course_id = $report['StudentCourseReport']['course_id'];
		$course_number_report = $this->StudentCourseReport->find('count',
				array('conditions' => array('course_id'=>$course_id),
                      'fields'=>array('DISTINCT StudentCourseReport.course_id')));
//		var_dump($course_number_report);
		
		$this->set('course_number_report', $course_number_report);
		$this->set('student', $user_student);
		$this->set('teacher', $user_teacher);
		$this->set('report', $report);
	}
	
}
	
	
