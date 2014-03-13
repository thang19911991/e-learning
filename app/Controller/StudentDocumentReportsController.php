<?php
class StudentDocumentReportsController extends  AppController {
	public $layout = 'admin';
	var $uses = array('StudentDocumentReport','User','Document','Course', 'Student', 'Teacher');

	public function index(){
		$this->redirect(array("controller" => "student_document_reports", "action" => "list_report"));
	}
	
	public function list_report(){
		$this->writeLog(array(
            'id' => 'AD_LOG_27_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'List all document copyright report',
            'content' => 'Admin '.$this->Auth->user('id').' view all document copyright report',
            'type' => 'operation'
        ));
		$reports = $this->StudentDocumentReport->find('all');
		$i = 0;
		foreach ($reports as $report){
			$course_id = $report['Document']['course_id'];
			$courses[$i] = $this->Course->findById($course_id);
			
			$student_id = $report['StudentDocumentReport']['student_id'];
			$student = $this->Student->findById($student_id);
			$user_student[$i] = $this->User->findById($student['Student']['user_id']);
//			echo '<pre>';
//			var_dump($report);
			$i++;
		}
		
		if(!empty($courses)){
			$this->set('courses', $courses);
		}
		
		if(!empty($students)){
			$this->set('students', $user_student);
		}
		
		if(!empty($reports)){
			$this->set('reports', $this->StudentDocumentReport->find('all'));
		}
	}
	
	public function list_report_of_document($document_id = null){
		$this->writeLog(array(
            'id' => 'AD_LOG_31_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'List all copyright report of document',
            'content' => 'User '.$this->Auth->user('id').' list all copyright report of document: '.$document_id,
            'type' => 'operation'
        ));
		if (!$document_id) {
			throw new NotFoundException(__('Invalid document'));
		}
		$reports = $this->StudentDocumentReport->find('all', array('conditions' => array('document_id' => $document_id)));
		if (!$reports) {
			throw new NotFoundException(__('No copyright report about this document'));
		}
//		echo '<pre>';
//		var_dump($course_id);
//		var_dump($reports);
//		die();
		$document = $this->Document->findById($document_id);
		$course_id = $document['Document']['course_id'];
		$course = $this->Course->findById($course_id);
		
		$i = 0;
		foreach ($reports as $report){
			$student_id = $report['StudentDocumentReport']['student_id'];
			$student = $this->Student->findById($student_id);
			$user_student[$i] = $this->User->findById($student['Student']['user_id']);
//			echo '<pre>';
//			var_dump($report);
			$i++;
		}
		$this->set('course', $course);
		$this->set('students', $user_student);
		$this->set('reports', $reports);
	}
	
	public function view_a_report($id = null){
		$this->writeLog(array(
            'id' => 'AD_LOG_32_001',
            'time' => time(),
            'actor' => $this->Auth->user('id'),
            'action' => 'View detail of a document copyright report',
            'content' => 'User '.$this->Auth->user('id').' view detail of a document copyright report, with Report: '.$id,
            'type' => 'operation'
        ));
		if (!$id) {
			throw new NotFoundException(__('Invalid report'));
		}
		$report = $this->StudentDocumentReport->findById($id);
		if (!$report) {
			throw new NotFoundException(__('Invalid report'));
		}
		
		$document_id = $report['StudentDocumentReport']['document_id'];
		$document_number_report = $this->StudentDocumentReport->find('count',
				array('conditions' => array('document_id'=>$document_id),
                      'fields'=>array('DISTINCT StudentDocumentReport.document_id')));
		
		$course_id = $report['Document']['course_id'];
		$course = $this->Course->findById($course_id);
		
		$teacher_id = $course['Course']['teacher_id'];
		$teacher = $this->Teacher->findById($teacher_id);
		$teacher_student = $this->User->findById($teacher['Teacher']['user_id']);
		
		$student_id = $report['StudentDocumentReport']['student_id'];
		$student = $this->Student->findById($student_id);
		$user_student = $this->User->findById($student['Student']['user_id']);
		
		
		
		$this->set('document_number_report', $document_number_report);
		$this->set('course', $course);
		$this->set('teacher', $teacher_student);
		$this->set('student', $user_student);
		$this->set('report', $report);
	}
	
}
	
	
