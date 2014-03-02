<?php
class Teacher extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "teachers";		
	
	public $hasMany = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'teacher_id',
			'dependent' => true
		)
	);
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('username'),
			'dependent' => true
		)
	);
}