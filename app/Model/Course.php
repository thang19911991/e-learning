<?php
class Course extends  AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL	
	public $name = "courses";
	
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
		)
	);
	
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
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