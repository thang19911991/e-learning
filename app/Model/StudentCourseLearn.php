<?php
class StudentCourseLearn extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "StudentCourseLearn";
	public $useTable = "students_courses_learn";
	
	public $belongsTo  =  array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id'
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id'
		)
	);
}