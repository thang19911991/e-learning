<?php
class Test extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "Test";
	
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id'
		)
	);
}