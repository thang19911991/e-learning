<?php
class Course extends  AppModel{
	public $name = "Course";
	
	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'teacher_id'
		)
	);
	
	public $hasMany = array(
		'Course_Tag' => array(
			'className' => 'CourseTag',
			'foreignKey' => 'course_id',
			'dependent' => true
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'course_id',
			'dependent' => true
		),
		'Test' => array(
			'className' => 'Test',
			'foreignKey' => 'course_id',
			'dependent' => true
		),
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'course_id',
			'dependent' => true
		)
	);
	
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'courses_tags',
			'foreignKey' => 'course_id'
		)
	);
	
	
	
	public $validate = array(
		'course_name' => array(
			'notEmpty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [コース名]',
			)
		),
		'description' => array(
			'notEmpty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [概要]',
			)
		)
	);
}